"use client";

import { Suspense, useState } from "react";
import Link from "next/link";
import { useRouter, useSearchParams } from "next/navigation";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { api, ApiError } from "@/lib/api";
import { useAuth } from "@/lib/auth";

// datetime-local gives "2026-07-15T09:00" → API wants "2026-07-15 09:00:00"
function toApiDateTime(local: string) {
  return `${local.replace("T", " ")}:00`;
}

function PrenotaForm() {
  const router = useRouter();
  const qc = useQueryClient();
  const params = useSearchParams();

  const { data: medici } = useQuery({ queryKey: ["medici"], queryFn: api.medici });
  const { data: servizi } = useQuery({ queryKey: ["servizi"], queryFn: api.servizi });
  const { data: sedi } = useQuery({ queryKey: ["sedi"], queryFn: api.sedi });

  const [medicoId, setMedicoId] = useState(params.get("medico") ?? "");
  const [servizioId, setServizioId] = useState(params.get("servizio") ?? "");
  const [sedeId, setSedeId] = useState(params.get("sede") ?? "");
  const [dataOra, setDataOra] = useState("");
  const [errors, setErrors] = useState<Record<string, string[]>>({});
  const [generalError, setGeneralError] = useState<string | null>(null);

  const mutation = useMutation({
    mutationFn: () =>
      api.creaAppuntamento({
        medico_id: Number(medicoId),
        servizio_id: Number(servizioId),
        sede_id: Number(sedeId),
        data_ora: toApiDateTime(dataOra),
      }),
    onSuccess: () => {
      qc.invalidateQueries({ queryKey: ["appuntamenti"] });
      router.push("/area-personale");
    },
    onError: (err) => {
      if (err instanceof ApiError) {
        setErrors(err.fieldErrors);
        if (Object.keys(err.fieldErrors).length === 0) setGeneralError(err.message);
      } else {
        setGeneralError("Prenotazione non riuscita. Riprova.");
      }
    },
  });

  const onSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setErrors({});
    setGeneralError(null);
    if (new Date(dataOra) <= new Date()) {
      setErrors({ data_ora: ["La data deve essere nel futuro."] });
      return;
    }
    mutation.mutate();
  };

  const field =
    "w-full rounded-xl border border-primary/20 bg-mint-soft px-4 py-3 text-sm text-heading outline-none focus:border-primary";

  const fieldError = (name: string) =>
    errors[name] ? (
      <p className="mt-1 text-xs text-red-600">{errors[name][0]}</p>
    ) : null;

  return (
    <div className="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-primary/10 sm:p-10">
      <h1 className="font-display text-3xl font-bold text-heading">
        Prenota una visita
      </h1>
      <p className="mt-1 text-heading/70">
        Scegli medico, servizio, sede e data.
      </p>

      <form onSubmit={onSubmit} className="mt-8 space-y-5">
        <div>
          <label className="mb-1 block text-sm font-semibold text-heading">Medico</label>
          <select
            className={field}
            required
            value={medicoId}
            onChange={(e) => setMedicoId(e.target.value)}
          >
            <option value="">Seleziona un medico…</option>
            {(medici ?? []).map((m) => (
              <option key={m.id} value={m.id}>
                {m.nome} {m.cognome}
                {m.specializzazione ? ` — ${m.specializzazione.nome}` : ""}
              </option>
            ))}
          </select>
          {fieldError("medico_id")}
        </div>

        <div>
          <label className="mb-1 block text-sm font-semibold text-heading">Servizio</label>
          <select
            className={field}
            required
            value={servizioId}
            onChange={(e) => setServizioId(e.target.value)}
          >
            <option value="">Seleziona un servizio…</option>
            {(servizi ?? []).map((s) => (
              <option key={s.id} value={s.id}>
                {s.nome} ({s.durata_default_min} min)
              </option>
            ))}
          </select>
          {fieldError("servizio_id")}
        </div>

        <div>
          <label className="mb-1 block text-sm font-semibold text-heading">Sede</label>
          <select
            className={field}
            required
            value={sedeId}
            onChange={(e) => setSedeId(e.target.value)}
          >
            <option value="">Seleziona una sede…</option>
            {(sedi ?? []).map((s) => (
              <option key={s.id} value={s.id}>
                {s.nome} — {s.citta}
              </option>
            ))}
          </select>
          {fieldError("sede_id")}
        </div>

        <div>
          <label className="mb-1 block text-sm font-semibold text-heading">
            Data e ora
          </label>
          <input
            type="datetime-local"
            className={field}
            required
            value={dataOra}
            onChange={(e) => setDataOra(e.target.value)}
          />
          {fieldError("data_ora")}
        </div>

        {generalError && (
          <p className="rounded-lg bg-red-50 px-4 py-2 text-sm text-red-600">
            {generalError}
          </p>
        )}

        <button
          type="submit"
          disabled={mutation.isPending}
          className="w-full rounded-full bg-primary px-6 py-3 font-medium text-white transition hover:bg-primary-dark disabled:opacity-60"
        >
          {mutation.isPending ? "Prenotazione…" : "Conferma prenotazione"}
        </button>
      </form>
    </div>
  );
}

export default function PrenotaPage() {
  const { paziente, loading } = useAuth();

  return (
    <section className="mx-auto max-w-xl px-6 py-14">
      {loading ? (
        <p className="text-center text-heading/60">Caricamento…</p>
      ) : !paziente ? (
        <div className="rounded-3xl bg-white p-10 text-center shadow-sm ring-1 ring-primary/10">
          <p className="text-heading/70">
            Devi accedere per prenotare una visita.
          </p>
          <Link
            href="/login"
            className="mt-4 inline-flex rounded-full bg-primary px-6 py-3 font-medium text-white transition hover:bg-primary-dark"
          >
            Vai al login
          </Link>
        </div>
      ) : (
        <Suspense fallback={<p className="text-center text-heading/60">Caricamento…</p>}>
          <PrenotaForm />
        </Suspense>
      )}
    </section>
  );
}
