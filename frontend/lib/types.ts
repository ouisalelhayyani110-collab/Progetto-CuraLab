// CuraLab API types — match the Laravel API verbatim (Italian field names).

export interface Specializzazione {
  id: number;
  nome: string;
  descrizione: string | null;
}

export interface Medico {
  id: number;
  nome: string;
  cognome: string;
  specializzazione_id: number;
  email: string | null;
  telefono: string | null;
  foto: string | null;
  biografia: string | null;
  specializzazione?: Specializzazione;
}

export interface Servizio {
  id: number;
  specializzazione_id: number;
  nome: string;
  descrizione: string | null;
  durata_default_min: number;
  specializzazione?: Specializzazione;
}

export interface Sede {
  id: number;
  nome: string;
  indirizzo: string;
  citta: string;
  cap: string | null;
  telefono: string | null;
  email: string | null;
}

export interface Paziente {
  id: number;
  nome: string;
  cognome: string;
  email: string;
  telefono: string | null;
  data_nascita: string | null;
  email_confermata: boolean;
  consenso_termini: boolean;
  consenso_privacy: boolean;
  created_at?: string;
  updated_at?: string;
}

export type StatoAppuntamento = "confermato" | "annullato" | "completato";

export interface Appuntamento {
  id: number;
  data_ora: string;
  durata_minuti: number;
  stato: StatoAppuntamento;
  note: string | null;
  paziente_id?: number;
  medico_id?: number;
  servizio_id?: number;
  sede_id?: number;
  medico?: Medico;
  servizio?: Servizio;
  sede?: Sede;
}

export interface RegisterPayload {
  nome: string;
  cognome: string;
  email: string;
  password: string;
  password_confirmation: string;
  consenso_termini: boolean;
  consenso_privacy: boolean;
}

export interface LoginPayload {
  email: string;
  password: string;
}

export interface ContattoPayload {
  nome: string;
  email: string;
  oggetto?: string;
  messaggio: string;
}

export interface CreaAppuntamentoPayload {
  medico_id: number;
  servizio_id: number;
  sede_id: number;
  data_ora: string;
}

export interface AuthResponse {
  paziente: Paziente;
  token: string;
}

export interface MessaggioResponse {
  messaggio: string;
}

export interface CreaAppuntamentoResponse {
  messaggio: string;
  appuntamento: Appuntamento;
}

export interface ContattoResponse {
  messaggio: string;
  data: unknown;
}
