Pour travailler sur le projet, il faut commencer par faire une copie du projet � partir de la branche 'master' sur votre machine
```
  git clone
```

Les commits interm�diaires doivent �tre fait sur une branche autre que le 'master'.
Il faut donc se placer sur une branche de travail
```
git checkout -b  ma_branche
```
et les commits doivent �tre fait avec la commande suivante
```
git commit -m 
```

pour envoyer les commits sur le repo distant
```
git push origin ma_branche
```
attention � bien faire un push sur votre branche de travail et non sur la branche 'master'

Une fois le d�veloppement termin� et test� il faut d�verser votre travail sur la branche 'master'
Depuis votre branche il faut faire un pull request vers la branche �master�, avec la commande :
```
git request-pull origin/master ma_branche
```

En conclusion, il ne faut jamais travailler sur la branche 'master'
