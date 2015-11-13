#!/bin/bash
H=$(echo "$3" | sed 's#"#\"#g')
P=$(echo "$4" | sed 's#"#\\\"#g')
echo curl -si $H -d \"$P\" --request $2 "$1" | sed 's/\r$//'
head=true;
while read -r line; do
    if $head; then 
      if [[ -z $line ]]; then 
        head=false
      else  
        headers+="$line"'\n'
      fi
    else 
      body+="$line"'\n'
    fi
done < <(echo "$(curl -si $H -d "$P" --request $2 "$1" | sed 's/\r$//')")
lineNum=0
newHeaders+="{"
while read -r line; do 
  if [ $lineNum -gt 0 ]; then
    if [ -z "$line" ]; then 
      continue
    else 
      newHeaders+=","
      line=$(echo $line | sed 's/;//' | sed 's/\ //' | sed 's/\"//g')
      newHeaders+="\"$(echo $line | cut -d':' -f1)\":\"$(echo $line | cut -d ':' -f 2)\""
    fi
  else 
    newHeaders+="\"code\":$(echo $line | cut -d' ' -f2)"
  fi
  lineNum=$(expr $lineNum + 1)
done < <(echo -e $headers)
newHeaders+="}"
echo "{\"headers\":$newHeaders, \"body\":\"$body\"}"
