use Libreria;

CREATE TABLE Utente (
	email VARCHAR(50),
	cognome VARCHAR(100) NOT NULL,
	nome VARCHAR(100) NOT NULL,
	password VARCHAR(50) NOT NULL,
	PRIMARY KEY (email)
);
CREATE TABLE libro (
	ISBN INTEGER(13) NOT NULL,
	autore VARCHAR(50) NOT NULL,
	titolo VARCHAR(50) NOT NULL,
	trama VARCHAR(50) NOT NULL,
	numero_letture INTEGER(10) NOT NULL,
	Data_aggiunta DATE NOT NULL,
	Data_eliminazione DATE NOT NULL,
	PRIMARY KEY (ISBN)
);

-- Trigger per l'eliminazione dei prodotti dal carrello
CREATE TRIGGER `Elimina_libro` BEFORE DELETE ON `libro`
 FOR EACH ROW INSERT INTO libro (ISBN,autore,titolo,trama,numero_letture,data_aggiunta,Data_eliminazione)
VALUES (old.ISBN,old.autore,old.titolo,old.trama,old.numero_letture,old.data_aggiunta,CURRENT_TIMESTAMP())
