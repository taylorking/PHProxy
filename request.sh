#!/bin/bash
head=true;
nl=$'\n'
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
done < <(echo "$(curl -si -d "" --request $2 "$1" | sed 's/\r$//')")
lineNum=0
newHeaders+="{"
while read -r line; do 
  if [ $lineNum -gt 0 ]; then
    if [ $lineNum -ne 1 ]; then
      if [ -z "$line" ]; then 
        continue;
      else
        newHeaders+=","
      fi
    fi
    if [ -z "$line" ]; then 
      continue
    else 
      line=$(echo $line | sed 's/;//' | sed 's/\ //' | sed 's/\"//g')
      newHeaders+="\"$(echo $line | cut -d':' -f1)\":\"$(echo $line | cut -d ':' -f 2)\""
    fi
  fi
  lineNum=$(expr $lineNum + 1)
done < <(echo -e $headers)
newHeaders+="}"
echo "{\"headers\":$newHeaders, \"body\":\"$body\"}"
