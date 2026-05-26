-- Crea il database se non esiste e lo seleziona
CREATE DATABASE IF NOT EXISTS curalab CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE curalab;

/* CHARACHTER SET per definire quali caratteri possono essere salvati nel DB, utf8mb4 significa che supporta tutti i caratteri Unicode 
(4 sta per 4byte, dimensione massima usata per codificare un singolo carattere)
COLLATE definisce le regole di confronto e ordinamento tra caratteri: utf8mb4 definisce quali caratteri può salvare; unicode indica che le regole di confronto 
seguono lo standard internazionale Unicode, quindi gestisce correttamente anche i caratteri accentati; ci sta per Case Insensitive, MySQL tratta maiuscole e 
minuscole allo stesso modo (utile per le mail) */

/* 1. SPECIALIZZAZIONI
Aree mediche del poliambulatorio.
Ogni medico appartiene a una specializzazione; ogni servizio è raggruppato sotto una specializzazione. */

CREATE TABLE specializzazioni (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descrizione TEXT,
    PRIMARY KEY (id),
    UNIQUE KEY uq_spec_nome (nome) -- due specializzazioni non possono avere lo stesso nome
);

INSERT INTO
    specializzazioni (nome, descrizione)
VALUES (
        'Cardiologia',
        'Diagnosi e cura delle malattie del cuore e del sistema cardiovascolare'
    ),
    (
        'Ginecologia',
        'Salute e prevenzione dell\'apparato riproduttivo femminile'
    ),
    (
        'Ortopedia',
        'Diagnosi e trattamento di ossa, muscoli, articolazioni e tendini'
    ),
    (
        'Ostetricia',
        'Assistenza medica in gravidanza, parto e puerperio'
    ),
    (
        'Dermatologia',
        'Diagnosi e cura delle malattie della pelle, capelli e unghie'
    ),
    (
        'Neurologia',
        'Diagnosi e cura delle malattie del sistema nervoso'
    ),
    (
        'Pediatria',
        'Salute, crescita e sviluppo di neonati e bambini'
    );


/* 2. SERVIZI
Prestazioni prenotabili, una per specializzazione.
La colonna descrizione alimenta il carosello pubblico.
-- FK: ON UPDATE CASCADE: se l'id della specializzazione cambia, si aggiorna automaticamente anche qui.
-- ON DELETE RESTRICT: non si può eliminare una specializzazione se ha ancora servizi collegati. */

CREATE TABLE servizi (
    id INT NOT NULL AUTO_INCREMENT,
    specializzazione_id INT NOT NULL,
    nome VARCHAR(150) NOT NULL,
    descrizione TEXT,
    durata_default_min INT NOT NULL DEFAULT 30, -- durata tipica dello slot in minuti
    PRIMARY KEY (id),
    CONSTRAINT fk_serv_spec FOREIGN KEY (specializzazione_id) REFERENCES specializzazioni (id) ON UPDATE CASCADE ON DELETE RESTRICT
);

INSERT INTO
    servizi (
        specializzazione_id,
        nome,
        descrizione,
        durata_default_min
    )
VALUES (
        1,
        'Visita cardiologica',
        'Valutazione della salute del cuore e del sistema cardiovascolare',
        30
    ),
    (
        2,
        'Visita ginecologica',
        'Controllo della salute e prevenzione dell\'apparato femminile',
        30
    ),
    (
        3,
        'Visita ortopedica',
        'Valutazione di ossa, articolazioni e apparato muscolo-scheletrico',
        30
    ),
    (
        4,
        'Visita ostetrica',
        'Controllo e assistenza medica in gravidanza e puerperio',
        30
    ),
    (
        5,
        'Visita dermatologica',
        'Diagnosi e trattamento delle malattie della pelle',
        30
    ),
    (
        6,
        'Visita neurologica',
        'Valutazione del sistema nervoso centrale e periferico',
        45
    ),
    (
        7,
        'Visita pediatrica',
        'Controllo della salute e dello sviluppo di neonati e bambini',
        30
    );


/* 3. SEDI
Sedi fisiche del poliambulatorio (Torino e provincia) */

CREATE TABLE sedi (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    indirizzo VARCHAR(255) NOT NULL,
    citta VARCHAR(100) NOT NULL,
    cap CHAR(5),
    telefono VARCHAR(20),
    email VARCHAR(150),
    PRIMARY KEY (id)
);

INSERT INTO
    sedi (
        nome,
        indirizzo,
        citta,
        cap,
        telefono,
        email
    )
VALUES (
        'CuraLab - Sede Principale',
        'Via della Salute 1',
        'Torino',
        '10140',
        '011 123456',
        'info@curalab.it'
    ),
    (
        'CuraLab - Sede Centro',
        'Corso Vittorio Emanuele 34',
        'Torino',
        '10123',
        '011 234567',
        'centro@curalab.it'
    ),
    (
        'CuraLab - Sede Mirafiori',
        'Via Giordano Bruno 12',
        'Torino',
        '10137',
        '011 345678',
        'mirafiori@curalab.it'
    ),
    (
        'CuraLab - Sede Moncalieri',
        'Via Roma 88',
        'Moncalieri',
        '10024',
        '011 456789',
        'moncalieri@curalab.it'
    ),
    (
        'CuraLab - Sede Collegno',
        'Corso Francia 200',
        'Collegno',
        '10093',
        '011 567890',
        'collegno@curalab.it'
    );


/* 4. MEDICI
Un medico appartiene a una specializzazione principale.
Le sedi dove opera e i servizi che eroga sono definiti nelle tabelle ponte medico_sede e medico_servizio.

foto: percorso del file immagine, NULL finché non viene caricata.
FK: ON DELETE RESTRICT: non si può eliminare una specializzazione se ha ancora medici collegati. */ 

CREATE TABLE medici (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cognome VARCHAR(100) NOT NULL,
    specializzazione_id INT NOT NULL,
    email VARCHAR(150),
    telefono VARCHAR(20),
    foto VARCHAR(255),
    biografia TEXT, -- testo breve per il carosello pubblico
    PRIMARY KEY (id),
    CONSTRAINT fk_med_spec FOREIGN KEY (specializzazione_id) REFERENCES specializzazioni (id) ON UPDATE CASCADE ON DELETE RESTRICT
);

INSERT INTO
    medici (
        nome,
        cognome,
        specializzazione_id,
        email,
        telefono,
        foto,
        biografia
    )
VALUES (
        'Marco',
        'Ferretti',
        1,
        'm.ferretti@curalab.it',
        '011 111001',
        NULL,
        'Cardiologo con 15 anni di esperienza in cardiologia interventistica e prevenzione cardiovascolare.'
    ),
    (
        'Alessia',
        'Conti',
        2,
        'a.conti@curalab.it',
        '011 111002',
        NULL,
        'Ginecologa con esperienza in ginecologia oncologica e medicina della riproduzione.'
    ),
    (
        'Roberto',
        'Esposito',
        3,
        'r.esposito@curalab.it',
        '011 111003',
        NULL,
        'Ortopedico specializzato in patologie del ginocchio e della spalla, esperto in medicina dello sport.'
    ),
    (
        'Francesca',
        'Ricci',
        4,
        'f.ricci@curalab.it',
        '011 111004',
        NULL,
        'Ostetrica con esperienza in assistenza alla gravidanza fisiologica e preparazione al parto.'
    ),
    (
        'Andrea',
        'Fontana',
        5,
        'a.fontana@curalab.it',
        '011 111005',
        NULL,
        'Dermatologo esperto in dermatologia estetica, mappatura nei e trattamento dell\'acne.'
    ),
    (
        'Paolo',
        'De Luca',
        6,
        'p.deluca@curalab.it',
        '011 111006',
        NULL,
        'Neurologo con esperienza in cefalee, epilessia e malattie neurodegenerative.'
    ),
    (
        'Giuseppe',
        'Ferrara',
        7,
        'g.ferrara@curalab.it',
        '011 111007',
        NULL,
        'Pediatra con esperienza in neonatologia e sviluppo psicomotorio del bambino.'
    );


/* 5. MEDICO_SEDE  (tabella ponte N:M)
Un medico può operare in più sedi; una sede può ospitare più medici.
La PK composta (medico_id, sede_id) impedisce duplicati.

FK: ON DELETE CASCADE: se si elimina un medico o una sede, le righe collegate vengono rimosse in automatico. */


CREATE TABLE medico_sede (
    medico_id INT NOT NULL,
    sede_id INT NOT NULL,
    PRIMARY KEY (medico_id, sede_id),
    CONSTRAINT fk_ms_medico FOREIGN KEY (medico_id) REFERENCES medici (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_ms_sede FOREIGN KEY (sede_id) REFERENCES sedi (id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO
    medico_sede (medico_id, sede_id)
VALUES (1, 1),
    (1, 2), -- Marco Ferretti: Sede Principale + Centro
    (2, 1),
    (2, 5), -- Alessia Conti: Sede Principale + Collegno
    (3, 1),
    (3, 3), -- Roberto Esposito: Sede Principale + Mirafiori
    (4, 1), -- Francesca Ricci: Sede Principale
    (5, 1),
    (5, 2), -- Andrea Fontana: Sede Principale + Centro
    (6, 1),
    (6, 4), -- Paolo De Luca: Sede Principale + Moncalieri
    (7, 1),
    (7, 3); -- Giuseppe Ferrara: Sede Principale + Mirafiori


/* 6. MEDICO_SERVIZIO  (tabella ponte N:M)
Un medico può erogare più servizi; un servizio può essere offerto da più medici. */

CREATE TABLE medico_servizio (
    medico_id INT NOT NULL,
    servizio_id INT NOT NULL,
    PRIMARY KEY (medico_id, servizio_id),
    CONSTRAINT fk_msv_medico FOREIGN KEY (medico_id) REFERENCES medici (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_msv_servizio FOREIGN KEY (servizio_id) REFERENCES servizi (id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO
    medico_servizio (medico_id, servizio_id)
VALUES (1, 1), -- Marco Ferretti: Visita cardiologica
    (2, 2), -- Alessia Conti: Visita ginecologica
    (3, 3), -- Roberto Esposito: Visita ortopedica
    (4, 4), -- Francesca Ricci: Visita ostetrica
    (5, 5), -- Andrea Fontana: Visita dermatologica
    (6, 6), -- Paolo De Luca: Visita neurologica
    (7, 7); -- Giuseppe Ferrara: Visita pediatrica

/*  7. DISPONIBILITA
Turni ricorrenti settimanali di ogni medico per sede.
giorno_settimana: 0=Lunedi, 1=Martedi, ... 5=Sabato
Il CHECK vincola i valori tra 0 e 5 (nessuna domenica).
 */

CREATE TABLE disponibilita (
    id INT NOT NULL AUTO_INCREMENT,
    medico_id INT NOT NULL,
    sede_id INT NOT NULL,
    giorno_settimana TINYINT NOT NULL,
    ora_inizio TIME NOT NULL,
    ora_fine TIME NOT NULL,
    durata_slot_minuti INT NOT NULL DEFAULT 30,
    PRIMARY KEY (id),
    CONSTRAINT fk_disp_medico FOREIGN KEY (medico_id) REFERENCES medici (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_disp_sede FOREIGN KEY (sede_id) REFERENCES sedi (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT chk_orario CHECK (ora_fine > ora_inizio),
    CONSTRAINT chk_giorno CHECK (
        giorno_settimana BETWEEN 0 AND 5
    )
);

INSERT INTO
    disponibilita (
        medico_id,
        sede_id,
        giorno_settimana,
        ora_inizio,
        ora_fine,
        durata_slot_minuti
    )
VALUES
    -- Marco Ferretti (cardiologo): sedi 1 e 2
    (1, 1, 0, '09:00', '13:00', 30), -- Lunedi mattina, Sede Principale
    (1, 1, 2, '14:00', '18:00', 30), -- Mercoledi pomeriggio, Sede Principale
    (1, 2, 4, '09:00', '13:00', 30), -- Venerdi mattina, Sede Centro

-- Alessia Conti (ginecologa): sedi 1 e 5
(2, 1, 1, '09:00', '13:00', 30), -- Martedi mattina, Sede Principale
(2, 1, 4, '14:00', '18:00', 30), -- Venerdi pomeriggio, Sede Principale
(2, 5, 3, '09:00', '13:00', 30), -- Giovedi mattina, Sede Collegno

-- Roberto Esposito (ortopedico): sedi 1 e 3
(3, 1, 0, '09:00', '13:00', 30), -- Lunedi mattina, Sede Principale
(3, 1, 3, '09:00', '13:00', 30), -- Giovedi mattina, Sede Principale
(3, 3, 5, '09:00', '12:00', 30), -- Sabato mattina, Sede Mirafiori

-- Francesca Ricci (ostetrica): sede 1
(4, 1, 1, '09:00', '13:00', 30), -- Martedi mattina, Sede Principale
(4, 1, 4, '09:00', '13:00', 30), -- Venerdi mattina, Sede Principale

-- Andrea Fontana (dermatologo): sedi 1 e 2
(5, 1, 2, '09:00', '13:00', 30), -- Mercoledi mattina, Sede Principale
(5, 2, 0, '14:00', '18:00', 30), -- Lunedi pomeriggio, Sede Centro
(5, 2, 5, '09:00', '12:00', 30), -- Sabato mattina, Sede Centro

-- Paolo De Luca (neurologo): sedi 1 e 4, slot da 45 min
(6, 1, 0, '14:00', '18:00', 45), -- Lunedi pomeriggio, Sede Principale
(6, 4, 3, '09:00', '13:00', 45), -- Giovedi mattina, Sede Moncalieri

-- Giuseppe Ferrara (pediatra): sedi 1 e 3
(7, 1, 2, '14:00', '18:00', 30), -- Mercoledi pomeriggio, Sede Principale
(7, 3, 5, '09:00', '12:00', 30); -- Sabato mattina, Sede Mirafiori


/* 8. PAZIENTI
Utenti registrati che accedono all'area personale e prenotano visite.

password_hash: la password non viene mai salvata in chiaro, solo il suo hash bcrypt (gestito da Laravel).
email_confermata: diventa TRUE dopo il click sul link di verifica inviato via email.
deleted_at: soft delete per GDPR — l'account viene marcato come eliminato ma i dati restano nel DB per i termini di conservazione obbligatori. */

CREATE TABLE pazienti (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cognome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    data_nascita DATE,
    codice_fiscale CHAR(16),
    email_confermata BOOLEAN NOT NULL DEFAULT FALSE,
    consenso_termini BOOLEAN NOT NULL DEFAULT FALSE,
    consenso_privacy BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_paz_email (email),
    UNIQUE KEY uq_paz_cf (codice_fiscale)
);

-- Pazienti di test (gli hash sono placeholder: in produzione Laravel li genera automaticamente con bcrypt al momento della registrazione)

INSERT INTO
    pazienti (
        nome,
        cognome,
        email,
        password_hash,
        telefono,
        data_nascita,
        codice_fiscale,
        email_confermata,
        consenso_termini,
        consenso_privacy
    )
VALUES (
        'Luca',
        'Bianchi',
        'luca.bianchi@email.it',
        '$2y$12$exampleHashLucaBianchi000000000000000000000000000000',
        '333 1111111',
        '1990-05-15',
        'BNCLCU90E15L219X',
        TRUE,
        TRUE,
        TRUE
    ),
    (
        'Sofia',
        'Greco',
        'sofia.greco@email.it',
        '$2y$12$exampleHashSofiaGreco0000000000000000000000000000000',
        '333 2222222',
        '1985-09-22',
        'GRCSFO85P62L219K',
        TRUE,
        TRUE,
        TRUE
    ),
    (
        'Marco',
        'Ferrari',
        'marco.ferrari@email.it',
        '$2y$12$exampleHashMarcoFerrari00000000000000000000000000000',
        '333 3333333',
        '1978-03-08',
        'FRRMRC78C08L219W',
        TRUE,
        TRUE,
        TRUE
    );

/* 9. TOKEN_VERIFICA
Token monouso per conferma email e reset password.
tipo: 
- 'conferma_email', inviato alla registrazione
- 'reset_password', inviato su richiesta
usato: diventa TRUE dopo il click, impedendo il riutilizzo.
scadenza: limite temporale (es. 24h per conferma, 1h per reset). */

CREATE TABLE token_verifica (
    id INT NOT NULL AUTO_INCREMENT,
    paziente_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    tipo ENUM(
        'conferma_email',
        'reset_password'
    ) NOT NULL,
    scadenza TIMESTAMP NOT NULL,
    usato BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_token (token),
    CONSTRAINT fk_tok_paziente FOREIGN KEY (paziente_id) REFERENCES pazienti (id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* 10. APPUNTAMENTI
Prenotazioni effettuate dai pazienti.
stato:
-'confermato': default al momento della prenotazione
-'annullato': paziente o staff ha disdetto
-'completato': visita avvenuta

FK: ON DELETE RESTRICT: non si possono eliminare pazienti, medici, servizi o sedi se hanno appuntamenti collegati. */

CREATE TABLE appuntamenti (
    id INT NOT NULL AUTO_INCREMENT,
    paziente_id INT NOT NULL,
    medico_id INT NOT NULL,
    servizio_id INT NOT NULL,
    sede_id INT NOT NULL,
    data_ora DATETIME NOT NULL,
    durata_minuti INT NOT NULL DEFAULT 30,
    stato ENUM(
        'confermato',
        'annullato',
        'completato'
    ) NOT NULL DEFAULT 'confermato',
    note TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_app_paziente FOREIGN KEY (paziente_id) REFERENCES pazienti (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_app_medico FOREIGN KEY (medico_id) REFERENCES medici (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_app_servizio FOREIGN KEY (servizio_id) REFERENCES servizi (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_app_sede FOREIGN KEY (sede_id) REFERENCES sedi (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Appuntamenti di test
INSERT INTO
    appuntamenti (
        paziente_id,
        medico_id,
        servizio_id,
        sede_id,
        data_ora,
        durata_minuti,
        stato,
        note
    )
VALUES (
        1,
        1,
        1,
        1,
        '2026-06-02 09:00:00',
        30,
        'confermato',
        NULL
    ), -- Luca: visita cardiologica
    (
        2,
        2,
        2,
        1,
        '2026-06-03 09:00:00',
        30,
        'confermato',
        'Prima visita'
    ), -- Sofia: visita ginecologica
    (
        3,
        7,
        7,
        1,
        '2026-06-04 14:00:00',
        30,
        'confermato',
        NULL
    ), -- Marco: visita pediatrica
    (
        1,
        6,
        6,
        1,
        '2026-05-10 14:00:00',
        45,
        'completato',
        NULL
    ); -- Luca: visita neurologica (gia svolta)

/* 11. RICHIESTE_CONTATTO
Messaggi inviati dal form "Contatti".
paziente_id è NULL se il mittente non è registrato:
ON DELETE SET NULL preserva il messaggio anche se il paziente elimina il proprio account. */

CREATE TABLE richieste_contatto (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    oggetto VARCHAR(255),
    messaggio TEXT NOT NULL,
    paziente_id INT DEFAULT NULL,
    presa_in_carico BOOLEAN NOT NULL DEFAULT FALSE,
    data_invio TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_cont_paziente FOREIGN KEY (paziente_id) REFERENCES pazienti (id) ON DELETE SET NULL ON UPDATE CASCADE
);

/* INDICI AGGIUNTIVI
Per migliorare le prestazioni delle query piu frequenti:
-ricerca appuntamenti per paziente, medico, data e stato;
-ricerca disponibilita per medico e giorno;
-ricerca token per paziente e tipo. */

CREATE INDEX idx_app_paziente ON appuntamenti (paziente_id);

CREATE INDEX idx_app_medico ON appuntamenti (medico_id);

CREATE INDEX idx_app_data ON appuntamenti (data_ora);

CREATE INDEX idx_app_stato ON appuntamenti (stato);

CREATE INDEX idx_disp_medico ON disponibilita (medico_id, giorno_settimana);

CREATE INDEX idx_tok_paziente ON token_verifica (paziente_id, tipo);

CREATE INDEX idx_serv_spec ON servizi (specializzazione_id);
