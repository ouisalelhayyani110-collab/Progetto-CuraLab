import type {
  AuthResponse,
  LoginPayload,
  RegisterPayload,
  Medico,
  Servizio,
  Sede,
  Paziente,
  Appuntamento,
  CreaAppuntamentoPayload,
  CreaAppuntamentoResponse,
  ContattoPayload,
  ContattoResponse,
  MessaggioResponse,
} from "./types";

const BASE_URL =
  process.env.NEXT_PUBLIC_API_BASE_URL ?? "http://localhost:8000/api";

const TOKEN_KEY = "curalab_token";

export const tokenStore = {
  get: () =>
    typeof window === "undefined" ? null : localStorage.getItem(TOKEN_KEY),
  set: (t: string) => localStorage.setItem(TOKEN_KEY, t),
  clear: () => localStorage.removeItem(TOKEN_KEY),
};

// Thrown on any non-2xx. Reads both `messaggio` (business) and `message` + `errors`
// (Laravel validation) shapes.
export class ApiError extends Error {
  status: number;
  body: { messaggio?: string; message?: string; errors?: Record<string, string[]> } | null;

  // User-facing messages are always Italian, regardless of the backend locale.
  private static readonly STATUS_IT: Record<number, string> = {
    401: "Sessione scaduta. Effettua di nuovo l'accesso.",
    403: "Non sei autorizzato a eseguire questa operazione.",
    404: "Risorsa non trovata.",
    419: "Sessione scaduta. Ricarica la pagina.",
    422: "Alcuni dati non sono validi.",
    429: "Troppe richieste. Riprova tra poco.",
    500: "Errore del server. Riprova più tardi.",
    503: "Servizio temporaneamente non disponibile.",
  };

  private static italianMessage(status: number, body: ApiError["body"]): string {
    const firstFieldError = body?.errors
      ? Object.values(body.errors)[0]?.[0]
      : undefined;
    return (
      body?.messaggio ??
      firstFieldError ??
      ApiError.STATUS_IT[status] ??
      "Si è verificato un errore. Riprova più tardi."
    );
  }

  constructor(status: number, body: ApiError["body"]) {
    super(ApiError.italianMessage(status, body));
    this.status = status;
    this.body = body;
  }

  get fieldErrors(): Record<string, string[]> {
    return this.body?.errors ?? {};
  }
}

interface RequestOptions {
  method?: string;
  body?: unknown;
  auth?: boolean;
}

export async function apiFetch<T>(
  path: string,
  opts: RequestOptions = {},
): Promise<T> {
  const { method = "GET", body, auth = false } = opts;

  const headers: Record<string, string> = {
    "Content-Type": "application/json",
    Accept: "application/json",
  };
  if (auth) {
    const token = tokenStore.get();
    if (token) headers.Authorization = `Bearer ${token}`;
  }

  const res = await fetch(`${BASE_URL}${path}`, {
    method,
    headers,
    body: body === undefined ? undefined : JSON.stringify(body),
  });

  const text = await res.text();
  const data = text ? JSON.parse(text) : null;

  if (!res.ok) {
    if (res.status === 401) tokenStore.clear();
    throw new ApiError(res.status, data);
  }
  return data as T;
}

export const api = {
  register: (p: RegisterPayload) =>
    apiFetch<AuthResponse>("/register", { method: "POST", body: p }),
  login: (p: LoginPayload) =>
    apiFetch<AuthResponse>("/login", { method: "POST", body: p }),
  logout: () =>
    apiFetch<MessaggioResponse>("/logout", { method: "POST", auth: true }),
  me: () => apiFetch<Paziente>("/user", { auth: true }),

  medici: () => apiFetch<Medico[]>("/medici"),
  servizi: () => apiFetch<Servizio[]>("/servizi"),
  sedi: () => apiFetch<Sede[]>("/sedi"),
  contatti: (p: ContattoPayload) =>
    apiFetch<ContattoResponse>("/contatti", { method: "POST", body: p }),

  appuntamenti: () => apiFetch<Appuntamento[]>("/appuntamenti", { auth: true }),
  creaAppuntamento: (p: CreaAppuntamentoPayload) =>
    apiFetch<CreaAppuntamentoResponse>("/appuntamenti", {
      method: "POST",
      body: p,
      auth: true,
    }),
  cancellaAppuntamento: (id: number) =>
    apiFetch<MessaggioResponse>(`/appuntamenti/${id}`, {
      method: "DELETE",
      auth: true,
    }),
};
