Les tests unitaires sont fait avec le logiciel phphunit. (https://phpunit.de/)  
## Pour installer phpunit:  
https://phpunit.de/manual/current/en/installation.html

## Pour lancer les tests, il suffit d'executer la commande suivante:  
  
     php phpunit.phar --testdox-html unit.html --coverage-html /resultatsTestPath    

## Les résultats des tests visibles grâce au fichier unit.html, et la couverture du code est disponible dans le répertoire  

     /resultatsTestPath  

## Ecriture des tests
Il est essentiel d'écrire à la fois des tests unitaires et des tests fonctionnels.  
Les tests unitaires ont pour vocation des tester les unités de manière isolée.
Les tests fonctionnels permette de vérifier la bonne intégration des différents composants de l'application.

* Les tests unitaires doivent être écrit dans le repertoire /tests
* Pour tester la classe Ma_classe, il faut créer une classe Ma_ClasseTest.
* Ma_ClasseTest doit hériter :
  * de WebTestCase : pour des tests fonctionnels,
  * de KernelTestCase : pour des tests unitaires,
  * ou de \PHPUnit_Framework_TestCase : pour des tests unitaires
* Les tests sont des méthodes publique dont le nom commence par test (ex testMaMethode).
* C'est au sein des méthodes de test, les méthodes d'assertion permettent de verifier qu'un objet a bien la valeur attendue.
La liste des méthodes d'assertion est visible ici :  
    https://phpunit.de/manual/current/en/appendixes.assertions.html

## Lecture des tests
L'ensemble des tests unitaires doivent être valide.

Le code covrage doit être important et très important sur les partes complexe de l'application.
