
# REQUISITI MINIMI
Sitema operativo Linux
Apache 2.2.x o superiore                    -> http://www.apache.org
MySQL 5.0 o superiore                        -> http://www.mysql.com
PHP    5.3.x o superiore con supporto GDlib 2    -> http://www.php.net

* Sitema operativo: Linux
* Apache 2.2.x
* MySQL 5.5
* PHP 5.3.x con estensioni:
   * PDO
   * PDO_mysql
   * JSON
   * GDlib 2
 
> La beta2 non funziona con PHP7

   
# CONFIGURAZIONE
Andare nella cartella di installazione e nella sottocartella application/config/.
Aprire il file config.xml e modificare i parametri di connessione come segue:
   
`<glz:Param name="DB_HOST" value="localhost" />`
`<glz:Param name="DB_NAME" value="mw_cms" />`
`<glz:Param name="DB_USER" value="root" />`
`<glz:Param name="DB_PSW" value="" />`
`<glz:Param name="SMTP_HOST" value="" />`
`<glz:Param name="SMTP_USER" value="" />`
`<glz:Param name="SMTP_PSW" value="" />`
`<glz:Param name="SMTP_SENDER" value="MIBAC" />`
`<glz:Param name="SMTP_EMAIL" value="me@me.com" />`

* DB_HOST: deve essere il nome dell'host del database mysql
* DB_NAME: nome del database
* DB_USER: nome utente per la connessione al database
* DB_PSW: password per la connessione al database
* SMTP_HOST: nome dell'host del server SMTP per l'invio delle email, lasciare
               vuoto per l'invio tramite server in locale
* SMTP_USER: se il server SMTP necessita di un'autenticazione specificare il nome utente
* SMTP_PSW: se il server SMTP necessita di un'autenticazione specificare la password
* SMTP_SENDER: nome del mittente quando il sistema invia una email
* SMTP_SENDER: email del mittente quando il sistema invia una email
  
## PER UTENTI ESPERTI 
Il sistema può funzionare con più file di configurazione, per uno sviluppatore può essere comodo avere un file di configurazione per il server di sviluppo ed uno per il server di produzione.
Per avere più file di configurazione duplicare il file config.xml e rinominarlo in config_nomeDominio.xml, cioè se per accedere al sito usate l'indirizzo www.server.com, il file di configurazione si chiamerà config_www.server.com; oppure se l'indirizzo è www.minervaeurope.org il file di configurazione sarà config_www.minervaeurope.org.xml
   
  
# CREAZIONE DATABASE
Utilizzando uno strumento di amministrazione di mySql (es. phpMyAdmin), creare il database mwcms, volendo è possibile utilizzare un'altro nome in questo caso è necessario modificare anche il parametro DB_NAME del file di configurazione (vedi punto 2).
Dopo la creazione del database è necessario importare il file SQL che si trova nella cartella "install/mysql".
Dentro questa cartella ci sono i seguenti file:

* mw_cms.sql: dump del database di un sito vuoto
* mw_cms_demo.sql: dump del database con contenuti dimostrativi
   

# CONFIGURAZIONE PERMESSI
Verificare che la cartella cache abbia i diritti in scrittura.
Verificare che le cartelle application/mediaArchive e le sue sottocartelle abbiano i diritti in scrittura.
Verificare che le cartelle application/classes/userModules abbia i diritti in scrittura.
Verificare che le cartelle application/config abbia i diritti in scrittura.
Verificare che le cartelle application/startup abbia i diritti in scrittura.
Verificare che le cartelle admin/cache abbia i diritti in scrittura.
Verificare che le cartelle admin/application/config abbia i diritti in scrittura.
Verificare che le cartelle admin/application/startup abbia i diritti in scrittura.
       
# IMPOSTAZIONI DI APACHE
Per il webserver Apache sono forniti i file .htaccess per impostare i giusti privilegi di lettura, è necessario che la configurazione di Apache accetti la lettura di questi file, controllare il parametro AllowOverride di Apache per il virtual-host del sito.
Su Apache deve essere anche abilitato il modulo Rewrite.

# VERIFICA
Aprire il browser all'indirizzo di installazione es. http://nomeserver.com per verificare che l'installazione sia avvenuta correttamente

# ACCESSO AMMINISTRAZIONE
Aprire il browser all'indirizzo di installazione es. http://nomeserver.com/admin/ per accedere all'amministrazione, la prima volta si può entrare con nome utente admin e password admin.
   


# MIGRAZIONE DA MWCMS 2
La procedura di migrazione di un sito MWCMS 2 è una procedura semiautomatica, non è consigliato installare MWCMS3 su una installazione esistente di MWCMS2 perché la struttura dei file e del DB sono molto differenti.
La procedura di migrazione porterà tutti i contenuti di MWCMS2 in MWCMS3 con le seguenti limitazioni:

* i documenti in bozza non verranno convertiti
* il template scelto e le personalizzazioni non verranno conservate perché MWCMS3 ha una gestione dei template completamente riscritta

## 1. Copia dei file dell'archivio media.
Copiare la cartella MW/mediaArchive di MWCMS2 in application/mediaArchive di MWCMS3

## 2. Configurazione
Nel file di configurazione di MWCM3 (vedi punto INSTALLAZIONE .2) aggiungere le seguenti righe

`<glz:Param name="DB_TYPE#2" value="mysql" />`
`<glz:Param name="DB_HOST#2" value="localhost" />`
`<glz:Param name="DB_NAME#2" value="mwcms" />`
`<glz:Param name="DB_USER#2" value="" />`
`<glz:Param name="DB_PSW#2" value="" />`
`<glz:Param name="DB_PREFIX#2" value="mw_" />`

inserendo i dati per accedere al database di MWCMS2.

## 3. Copia script di migrazione
Copiare il file install/migrate.php nella cartella src.

## 4. Migrazione contenuti
Aprire il browser sull'indirizzo http://nomeserver.com/migrate.php la procedura richiede qualche minuto.

## 5. Verifica
Al termine della procedura entrando in amministrazione si troveranno i dati migrati.

## 6. Rimozione script di migrazione
Cancellare il file dalla cartella src.



