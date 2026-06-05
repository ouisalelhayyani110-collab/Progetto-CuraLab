# CuraLab — Guida all'API per il Frontend

## Cos'è questa API

Il backend di CuraLab è un'API REST: non genera pagine HTML, ma risponde sempre con **dati in formato JSON**. Il frontend NextJS fa richieste HTTP a questi indirizzi e usa i dati ricevuti per costruire l'interfaccia.

---

## Indirizzo base

L'API gira su un Codespace GitHub. Durante lo sviluppo l'indirizzo sarà del tipo:

```
https://<nome-codespace>-8000.app.github.dev
```

Tutti gli endpoint iniziano con `/api`. Esempio: `/api/medici`

---

## Regola fondamentale: gli header

Ogni richiesta deve sempre avere questi due header:

```
Content-Type: application/json
Accept: application/json
```

Per le pagine riservate ai pazienti autenticati, serve anche il token:

```
Authorization: Bearer IL_TOKEN_RICEVUTO_AL_LOGIN
```

---

## Come funziona il login

1. L'utente inserisce email e password → il frontend chiama `POST /api/login`
2. Il backend risponde con i dati del paziente **e un token**
3. Il frontend salva il token (in localStorage o in un cookie)
4. Da quel momento, ogni richiesta alle aree riservate include il token nell'header
5. Al logout, il frontend chiama `POST /api/logout` e il token viene invalidato

---

## Endpoint disponibili

### 1. Registrazione — `POST /api/register`
Crea un nuovo account paziente. Non serve il token.

Dati da inviare:
```json
{
  "nome": "Mario",
  "cognome": "Rossi",
  "email": "mario.rossi@email.it",
  "password": "Password123!",
  "password_confirmation": "Password123!",
  "consenso_termini": true,
  "consenso_privacy": true
}
```

Risposta in caso di successo (codice 201):
```json
{
  "paziente": {
    "id": 4,
    "nome": "Mario",
    "cognome": "Rossi",
    "email": "mario.rossi@email.it"
  },
  "token": "1|abc123xyz..."
}
```

---

### 2. Login — `POST /api/login`
Autentica un paziente esistente. Non serve il token.

Dati da inviare:
```json
{
  "email": "mario.rossi@email.it",
  "password": "Password123!"
}
```

Risposta in caso di successo (codice 200):
```json
{
  "paziente": {
    "id": 4,
    "nome": "Mario",
    "cognome": "Rossi",
    "email": "mario.rossi@email.it"
  },
  "token": "1|abc123xyz..."
}
```

Se le credenziali sono sbagliate risponde con codice 422 e un messaggio di errore.

---

### 3. Logout — `POST /api/logout`
🔒 Richiede il token. Invalida il token del paziente.

Non servono dati nel body. Risposta:
```json
{
  "messaggio": "Logout effettuato con successo."
}
```

---

### 4. Dati paziente corrente — `GET /api/user`
🔒 Richiede il token. Restituisce i dati del paziente autenticato.

Risposta:
```json
{
  "id": 4,
  "nome": "Mario",
  "cognome": "Rossi",
  "email": "mario.rossi@email.it",
  "telefono": "333 1111111",
  "data_nascita": "1990-05-15",
  "email_confermata": true,
  "consenso_termini": true,
  "consenso_privacy": true
}
```

> Nota: password e codice fiscale non vengono mai restituiti per motivi di sicurezza.

---

### 5. Lista medici — `GET /api/medici`
Pubblica, non serve il token. Restituisce tutti i medici con la loro specializzazione. Utile per il carosello.

Risposta:
```json
[
  {
    "id": 1,
    "nome": "Marco",
    "cognome": "Ferretti",
    "telefono": "011 111001",
    "foto": null,
    "biografia": "Cardiologo con 15 anni di esperienza...",
    "specializzazione": {
      "id": 1,
      "nome": "Cardiologia",
      "descrizione": "Diagnosi e cura delle malattie del cuore..."
    }
  },
  ...altri medici...
]
```

---

### 6. Lista servizi — `GET /api/servizi`
Pubblica, non serve il token. Restituisce tutti i servizi con la loro specializzazione. Utile per il carosello.

Risposta:
```json
[
  {
    "id": 1,
    "nome": "Visita cardiologica",
    "descrizione": "Valutazione della salute del cuore...",
    "durata_default_min": 30,
    "specializzazione": {
      "id": 1,
      "nome": "Cardiologia"
    }
  },
  ...altri servizi...
]
```

---

### 7. Lista sedi — `GET /api/sedi`
Pubblica, non serve il token. Restituisce tutte le sedi del poliambulatorio.

Risposta:
```json
[
  {
    "id": 1,
    "nome": "CuraLab - Sede Principale",
    "indirizzo": "Via della Salute 1",
    "citta": "Torino",
    "cap": "10140",
    "telefono": "011 123456",
    "email": "info@curalab.it"
  },
  ...altre sedi...
]
```

---

### 8. Form contatti — `POST /api/contatti`
Pubblica. Funziona sia per utenti registrati che non. Se l'utente è loggato, il token può essere incluso ma non è obbligatorio.

Dati da inviare:
```json
{
  "nome": "Mario Rossi",
  "email": "mario@email.it",
  "oggetto": "Informazioni orari",
  "messaggio": "Vorrei sapere gli orari della sede di Moncalieri."
}
```

`oggetto` è opzionale, il resto è obbligatorio. Risposta (codice 201):
```json
{
  "messaggio": "Richiesta inviata con successo."
}
```

---

### 9. Lista appuntamenti del paziente — `GET /api/appuntamenti`
🔒 Richiede il token. Restituisce gli appuntamenti del paziente autenticato, dal più recente.

Risposta:
```json
[
  {
    "id": 1,
    "data_ora": "2026-06-10T09:00:00.000000Z",
    "durata_minuti": 30,
    "stato": "confermato",
    "note": null,
    "medico": {
      "id": 1,
      "nome": "Marco",
      "cognome": "Ferretti"
    },
    "servizio": {
      "id": 1,
      "nome": "Visita cardiologica"
    },
    "sede": {
      "id": 1,
      "nome": "CuraLab - Sede Principale",
      "citta": "Torino"
    }
  }
]
```

Lo `stato` può essere: `confermato`, `annullato`, o `completato`.

---

### 10. Prenota un appuntamento — `POST /api/appuntamenti`
🔒 Richiede il token.

Dati da inviare:
```json
{
  "medico_id": 1,
  "servizio_id": 1,
  "sede_id": 1,
  "data_ora": "2026-07-15 09:00:00"
}
```

Regole:
- `data_ora` deve essere nel futuro
- `medico_id`, `servizio_id` e `sede_id` devono essere id validi (recuperabili dagli endpoint pubblici)

Risposta (codice 201):
```json
{
  "messaggio": "Appuntamento prenotato con successo.",
  "appuntamento": { ...dati completi dell'appuntamento... }
}
```

---

### 11. Cancella un appuntamento — `DELETE /api/appuntamenti/{id}`
🔒 Richiede il token. Al posto di `{id}` va messo il numero dell'appuntamento da cancellare.

Esempio: `DELETE /api/appuntamenti/1`

Risposta in caso di successo:
```json
{
  "messaggio": "Appuntamento cancellato con successo."
}
```

Possibili errori:
- Codice `403`: l'appuntamento non appartiene al paziente che sta facendo la richiesta
- Codice `422`: non si può cancellare nelle 24 ore precedenti all'appuntamento

> L'appuntamento non viene eliminato dal database — il suo stato cambia in `annullato`.

---

## Account di test già disponibili

Questi pazienti esistono già nel database e si possono usare subito per testare:

| Nome | Email | Password |
|------|-------|----------|
| Luca Bianchi | luca.bianchi@email.it | password |
| Sofia Greco | sofia.greco@email.it | password |
| Marco Ferrari | marco.ferrari@email.it | password |

Nel database ci sono già anche:
- **7 medici** (uno per specializzazione)
- **7 servizi** (uno per specializzazione)
- **5 sedi** (Torino e provincia)
- **4 appuntamenti di test**

---

## CORS

Il backend accetta richieste da qualsiasi dominio — nessuna configurazione speciale necessaria in sviluppo. In produzione andrà aggiunto il dominio del frontend.
