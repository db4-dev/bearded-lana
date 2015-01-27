<?php
  
require_once 'SepaXmlCreator.php';

class MainTest extends PHPUnit_Framework_TestCase
{
    public function testMain()
    {
        // Erzeugen einer neuen Instanz
        $creator = new SepaXmlCreator();

        /*
         * Mit den Account-Werten wird das eigene Konto beschrieben
         * erster Parameter = Name
         * zweiter Parameter = IBAN
         * dritter Paramenter = BIC
         */
        $creator->setAccountValues('mein Name', 'DE89370400440532013000', 'HANDFIHH');

        /*
         * Setzen Sie von der Bundesbank übermittelte Gläubiger-ID
         */
        $creator->setGlaeubigerId("DE98ZZZ09999999999");

        // Erzeugung einer neuen Buchungssatz
        $buchung = new SepaBuchung();
        $buchung->setBetrag(10);
        $buchung->setEnd2End('ID-00002');
        $buchung->setBic('EMPFAENGERBIC');
        $buchung->setName('Mustermann, Max');
        $buchung->setIban('DE1234566..');
        $buchung->setVerwendungszweck('Test Buchung');

        // Referenz auf das vom Kunden erteilte Lastschriftmandat
        // ID = MANDAT0001
        // Erteilung durch Kunden am 20. Mai 2013
        // False = seit letzter Lastschrift wurde am Mandat nichts geändert
        $buchung->setMandat("MANDAT0001", "2013-05-20", false);

        // Buchung zur Liste hinzufügen
        $creator->addBuchung($buchung);

        // Dies kann beliebig oft wiederholt werden ...
        $buchung = new SepaBuchung();
        $buchung->setBetrag(7);
        $buchung->setBic('EMPFAENGERBIC');
        $buchung->setName('Mustermann, Max');
        $buchung->setIban('DE1234566..');
        $buchung->setMandat("MANDAT0002");
        $creator->addBuchung($buchung);

        // Nun kann die XML-Datei über den Aufruf der entsprechenden Methode generiert werden
        echo $creator->generateBasislastschriftXml();
    
        // Assert
        $this->assertTrue(true);
    }

}