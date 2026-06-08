"use client";

import { useState } from "react";
import { api, ApiError } from "@/lib/api";

export default function ContactForm() {
  const [form, setForm] = useState({
    nome: "",
    email: "",
    oggetto: "",
    messaggio: "",
  });
  const [status, setStatus] = useState<"idle" | "sending" | "ok" | "error">(
    "idle",
  );
  const [error, setError] = useState<string | null>(null);

  const onSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setStatus("sending");
    setError(null);
    try {
      await api.contatti({
        nome: form.nome,
        email: form.email,
        oggetto: form.oggetto || undefined,
        messaggio: form.messaggio,
      });
      setStatus("ok");
      setForm({ nome: "", email: "", oggetto: "", messaggio: "" });
    } catch (err) {
      setStatus("error");
      setError(
        err instanceof ApiError ? err.message : "Invio non riuscito. Riprova.",
      );
    }
  };

  const field =
    "w-full rounded-xl border border-primary/20 bg-mint-soft px-4 py-3 text-sm text-heading outline-none focus:border-primary";

  return (
    <form onSubmit={onSubmit} className="space-y-4" noValidate>
      <h2 className="font-display text-xl font-semibold text-primary-dark">
        Scrivici un messaggio
      </h2>
      <input
        className={field}
        placeholder="Nome e cognome"
        aria-label="Nome e cognome"
        autoComplete="name"
        required
        value={form.nome}
        onChange={(e) => setForm({ ...form, nome: e.target.value })}
      />
      <input
        className={field}
        type="email"
        placeholder="Email"
        aria-label="Email"
        autoComplete="email"
        required
        value={form.email}
        onChange={(e) => setForm({ ...form, email: e.target.value })}
      />
      <input
        className={field}
        placeholder="Oggetto (facoltativo)"
        aria-label="Oggetto"
        value={form.oggetto}
        onChange={(e) => setForm({ ...form, oggetto: e.target.value })}
      />
      <textarea
        className={`${field} min-h-32`}
        placeholder="Il tuo messaggio"
        aria-label="Messaggio"
        required
        value={form.messaggio}
        onChange={(e) => setForm({ ...form, messaggio: e.target.value })}
      />

      {status === "ok" && (
        <p
          role="status"
          className="rounded-lg bg-primary/10 px-4 py-2 text-sm text-primary-dark"
        >
          Richiesta inviata con successo. Ti risponderemo presto!
        </p>
      )}
      {status === "error" && error && (
        <p role="alert" className="rounded-lg bg-red-50 px-4 py-2 text-sm text-red-700">
          {error}
        </p>
      )}

      <button
        type="submit"
        disabled={status === "sending"}
        className="w-full rounded-full bg-primary px-6 py-3 font-medium text-white transition hover:bg-primary-dark disabled:opacity-60"
      >
        {status === "sending" ? "Invio…" : "Invia messaggio"}
      </button>
    </form>
  );
}
