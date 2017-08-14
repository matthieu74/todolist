Les tests unitaires sont fait avec le logiciel phphunit. (https://phpunit.de/)  
## Pour installer phpunit:  
https://phpunit.de/manual/current/en/installation.html

## Pour lancer les tests, il suffit d'executer la commande suivante:  
  
     php phpunit.phar --testdox-html unit.html --coverage-html /resultatsTestPath    

## Les r�sultats des tests visibles gr�ce au fichier unit.html, et la couverture du code est disponible dans le r�pertoire  

     /resultatsTestPath  

## Ecriture des tests
Il est essentiel d'�crire � la fois des tests unitaires et des tests fonctionnels.  
Les tests unitaires ont pour vocation des tester les unit�s de mani�re isol�e.
Les tests fonctionnels permette de v�rifier la bonne int�gration des diff�rents composants de l'application.

* Les tests unitaires doivent �tre �crit dans le repertoire /tests
* Pour tester la classe Ma_classe, il faut cr�er une classe Ma_ClasseTest.
* Ma_ClasseTest doit h�riter :
  * de WebTestCase : pour des tests fonctionnels,
  * de KernelTestCase : pour des tests unitaires,
  * ou de \PHPUnit_Framework_TestCase : pour des tests unitaires
* Les tests sont des m�thodes publique dont le nom commence par test (ex testMaMethode).
* C'est au sein des m�thodes de test, les m�thodes d'assertion permettent de verifier qu'un objet a bien la valeur attendue.
La liste des m�thodes d'assertion est visible ici :  
    https://phpunit.de/manual/current/en/appendixes.assertions.html

## Lecture des tests
L'ensemble des tests unitaires doivent �tre valide.

Le code covrage doit �tre important et tr�s important sur les partes complexe de l'application.
