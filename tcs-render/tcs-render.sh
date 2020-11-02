#! /bin/bash
{
set -ex

final_file_list=$(mktemp)

function cleartmp {
    rm $final_file_list
}
trap cleartmp EXIT

CURRENT_PATH=$(cd $(dirname "${BASH_SOURCE[0]}"); pwd)

TEMPLATE_FILE_LIST=
TEMPLATE_FILE=
TEMPLATE_DIRECTORY=
VALUE_DATA_FILE=
LEFT_DELIMITER=
RIGHT_DELIMITER=

DEFAULT_VALUE_DATA_FILE=${TCS_TEMPLATE_CONFIG_VALUE_DATA_FILE:-'/tce/conf/cm/local.json'}
DEFAULT_TEMPLATE_FILE_LIST=${TCS_TEMPLATE_CONFIG_FILE_LIST:-'/etc/configuration-template.txt'}

usage()
{
cat << EOF
USAGE: $0 -l config_template_file_list -v template_value_data_file

OPTIONS:
   -h Show this message
   -f a single tempate file that needs to be rendered
   -l a file list that contains all tempate file which needs to be rendered
   -d a directory that contains all tempate file which needs to be rendered
   -v a json format tempate value data file used to render the template file(usually is local.json)
   -b left delimiter of template
   -r right delimier of template
EOF
}

while getopts hd:f:l:v:b:r: o
do
    case "$o" in
    h)  usage
        exit 0
        ;;
    l) TEMPLATE_FILE_LIST=$OPTARG
        ;;
    d) TEMPLATE_DIRECTORY=$OPTARG
        ;;
    f) TEMPLATE_FILE=$OPTARG
        ;;
    v) VALUE_DATA_FILE=$OPTARG
        ;;
    b) LEFT_DELIMITER=$OPTARG
        ;;
    r) RIGHT_DELIMITER=$OPTARG
        ;;
    [?])
        usage
        exit 1;;
    esac
done
shift "$((OPTIND -1))"

err() { echo "$*" >&2; }

BIN=tcs-render
# ${CURRENT_PATH}/../output/bin is for local test
export PATH=${CURRENT_PATH}:${CURRENT_PATH}/bin/:${CURRENT_PATH}/../output/bin:${PATH}

which tcs-render
type tcs-render 2>/dev/null || {
    err "tcs-render tool not found"
    exit 1
}

DRY_RUN=${DRY_RUN:-no}
ARGS="--inplace"
if [[ ${DRY_RUN} == "yes" ]];
then
    ARGS=""
fi

if [[ ${LEFT_DELIMITER} != "" ]];
then
    ARGS=$ARGS" -l "${LEFT_DELIMITER}
fi

if [[ ${RIGHT_DELIMITER} != "" ]];
then
    ARGS=$ARGS" -r "${RIGHT_DELIMITER}
fi

if [[ "${VALUE_DATA_FILE}" == "" ]]; then
    VALUE_DATA_FILE=${DEFAULT_VALUE_DATA_FILE}
fi

if grep -q -v "=" ${VALUE_DATA_FILE} ; then
   if  [[ ! -f ${VALUE_DATA_FILE} ]]; then
        err "tempate value data file ${VALUE_DATA_FILE} not exists"
        usage
        exit 1
    fi 
fi

if [[ "${TEMPLATE_FILE}" != "" ]]; then
    ${BIN} -v ${VALUE_DATA_FILE} -i ${TEMPLATE_FILE} ${ARGS}
    exit $?
fi

if [[ "${TEMPLATE_FILE_LIST}" == "" ]]; then
    TEMPLATE_FILE_LIST=${DEFAULT_TEMPLATE_FILE_LIST}
fi

if [[ -f ${TEMPLATE_FILE_LIST} ]]; then
    cat ${TEMPLATE_FILE_LIST} >${final_file_list}
fi
TEMPLATE_FILE_LIST=${final_file_list}
echo >>${TEMPLATE_FILE_LIST}

if [[ -d ${TEMPLATE_DIRECTORY} ]]; then
    find $(cd ${TEMPLATE_DIRECTORY}; pwd) -type f -exec grep -Iq . {} \; -print >>${TEMPLATE_FILE_LIST}
fi
cat ${TEMPLATE_FILE_LIST}

while IFS= read -r file || [ -n "$file" ]; do
    file=`echo ${file} | sed 's/^[[:space:]]*//;s/[[:space:]]*$//'`
    [[   -z "${file}" ]] && continue
    [[ ! -f "${file}" ]] && { err "file ${file} not exists"; continue; }

    ${BIN} -v ${VALUE_DATA_FILE} -i ${file} ${ARGS}
done <"${TEMPLATE_FILE_LIST}"
}
