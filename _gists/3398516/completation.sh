# Bash completation for application

_my_application()
{
	local cur prev opts job
	COMPREPLY=()
	job="${COMP_WORDS[0]}"
	cur="${COMP_WORDS[COMP_CWORD]}"
	prev="${COMP_WORDS[COMP_CWORD-1]}"

	if [[ ${COMP_CWORD} = 1 ]] ; then
		opts=$(${job} __check__)
		COMPREPLY=( $(compgen -W "${opts}" -- ${cur}) )
		return 0
	fi

	if [[ ${COMP_CWORD} = 2 ]] ; then
		opts=$(${job} __check__ $prev)
		COMPREPLY=( $(compgen -W "${opts}" -- ${cur}) )
		return 0
	fi

	COMPREPLY=( $(compgen -W "${opts}" -- ${cur}) )
	return 0;
}

complete -F _my_application job
