<?php

// Diese Datei dient ausschließlich dazu, die notwendigen Strukture in der Datenbank 
// anzulegen. Die Datei muss daher nur einmal ausgefürt werden. Anschließend sind
// alle notwendigen Tabellen angelegt und mit Beispieldaten belegt.


// Folgende Informationen sind bekannt:
// 
// Datenbankserver:   localhost
// Datenbankname:     dhbwvs20_rzptvw
// Datenbankuser:     dhbwvs20_dbuser1 
// Datenbankkennwort: dbuser1pwd


// Einbinden der RedBean-Funktionalität. Die Datei 'rb.php' befindet sich im 
// gleichen Verzeichnis, wie diese Datei. Ab jetzt steht die Klasse R zur Verfügung!

require 'rb.php';


// Die Methode statische 'setup' der Klasse R ermöglicht den Aufbau einer Verbindung
// zur Datenbank. In der ersten Zeichenkette ist der Name der Servers, auf welchem
// das DBMS läuft (localhost) und der Name der Datenbank kodiert (bundesliga).
// Die beiden weiteren Parameter legen den Namen und das Kennwort des DB-Benutzers
// fest.
//
// Benutzer von bplaced müssen drei der Parameter hier anpassen! Lediglich der 
// Servername (localhost) kann übernommen werden!

R::setup('mysql:host=localhost;dbname=Aufgabenliste', 'root', '');

  



// ### Neue Person anlegen ... ###
$nutzer = R::dispense('person');    //Achtung Namenskonvention: Beans (hier: person) müssen komplett klein geschrieben werden

// ...und die gewünschten Eigenschaften hinzufügen

$nutzer->name = "Ronja";
$nutzer->kennwort = "12345";


// ### Neues Aufgabenliste anlegen ... ###
	
$aufgabenliste = R::dispense('aufgabenliste');    //Achtung Namenskonvention: Beans (hier: rezept) müssen komplett klein geschrieben werden

// ...und die gewünschten Eigenschaften hinzufügen

$aufgabenliste->name = "DH";
$aufgabenliste->beschreibung = "Semester 4 Aufgaben";


// ### Neue Aufgabe anlegen ... ###

$aufgabe = R::dispense('aufgabe');    //Achtung Namenskonvention: Beans (hier: zutat) müssen komplett klein geschrieben werden

// ...und die gewünschten Eigenschaften hinzufügen

$aufgabe->titel = "Projekt Perschke";
$aufgabe->beschreibung = "Eine To-Do Liste mit Angular, PHP und MariaDB erstellen";
$aufgabe->gewichtung = 5;
$aufgabe->zeitpunkt = "03.07.2020";
$aufgabe->fortschritt = "in Bearbeitung";


// ### Aufgabe der Aufgabenliste zuordnen (1:n) ###

$aufgabenliste->xownAufgabenListe[] = $aufgabe;


// ### Person der Aufgabenliste zuordnen (1:1) ###

$rezept->person = $koch;




// ...Aufgabenliste inkl. Person und Aufgabe speichern

$id = R::store($aufgabenliste);   // RedBean untersucht die erstellten Beans und erstellt, falls noch nicht vorhanden
                           // für jedes Bean eine eigene Tabelle. Die Spalten der Tabelen werden durch die
                           // Eigenschaften der Beans festgelegt. Typen werden dabei automatisch erkannt.








// ### Zur Kontrolle wird das eben angelegte Rezept geladen und inklusiv aller verknüpften Daten ausgegeben ###




$aufgabenliste = R::load('aufgabenliste', $id);     // In der Tabelle 'aufgabenliste' wird nach dem Datensatz mit der 'id' $id gesucht.

//Ausgabe der Aufgabendaten

echo "<h3>Aufgabenlisten</h3>";
echo "Listenname: " . $aufgabenliste->name . "<br>";
echo "Listenbeschreibung: " . $aufgabenliste->beschreibung . "<br>";

echo "--------------";

echo "<h3>Person</h3>";
$nutzer = $aufgabenliste->person;
echo "Name: " . $nutzer->name . "<br>";
echo "Kennwort: " . $nutzer->kennwort . "<br>";
echo "&nbsp;<br>";

echo "--------------";

echo "<h3>Zutaten</h3>";
foreach($aufgabenliste->xownAufgabenListe as $z) {
    echo "Titel: " . $z->titel . "<br>";
    echo "Beschreibung: " . $z->beschreibung . "<br>";
    echo "Gewichtung: " . $z->gewichtung . "<br>";
    echo "Zeitpunkt: " . $z->zeitpunkt . "<br>";
    echo "Fortschritt: " . $z->fortschritt . "<br>";
    echo "&nbsp;<br>";
}
	



// Spätestens am Ende des Programms sollte die Verbindung zum DBMS wieder geschlossen
// werden. Dazu steht die Methode "close()" bereit.

R::close();

?>
