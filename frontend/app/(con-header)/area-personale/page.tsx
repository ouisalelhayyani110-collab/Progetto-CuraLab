"use client";

import Link from "next/link";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { api, ApiError } from "@/lib/api";
import { useAuth } from "@/lib/auth";
import type { Appuntamento, StatoAppuntamento } from "@/lib/types";

const STATO_STYLE: Record<StatoAppuntamento, string> = {
  confermato: "bg-primary/15 text-primary-dark",
  completato: "bg-heading/10 text-heading/70",
  annullato: "bg-red-100 text-red-600",
};

function formatData(iso: string) {
  return new Date(iso).toLocaleString("it-IT", {
    dateStyle: "long",
    timeStyle: "short",
  });
}

function AppuntamentoRow({ a }: { a: Appuntamento }) {
  const qc = useQueryClient();
  const cancel = useMutation({
    mutationFn: () => api.cancellaAppuntamento(a.id),
    onSuccess: () => qc.invalidateQueries({ queryKey: ["appuntamenti"] }),
  });

  return (
    <li className="flex flex-col gap-3 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-primary/10 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <p className="font-display font-semibold text-heading">
          {a.servizio?.nome ?? "Visita"}
        </p>
        <p className="text-sm text-heading/70">
          {a.medico ? `Dr. ${a.medico.nome} ${a.medico.cognome}` : ""}
          {a.sede ? ` · ${a.sede.nome}` : ""}
        </p>
        <p className="mt-1 text-sm text-heading/60">{formatData(a.data_ora)}</p>
      </div>
      <div className="flex items-center gap-3">
        <span
          className={`rounded-full px-3 py-1 text-xs font-semibold capitalize ${STATO_STYLE[a.stato]}`}
        >
          {a.stato}
        </span>
        {a.stato === "confermato" && (
          <button
            onClick={() => cancel.mutate()}
            disabled={cancel.isPending}
            className="rounded-full border border-red-200 px-3 py-1 text-xs font-medium text-red-600 transition hover:bg-red-50 disabled:opacity-60"
          >
            {cancel.isPending ? "…" : "Annulla"}
          </button>
        )}
      </div>
    </li>
  );
}

export default function AreaPersonalePage() {
  const { paziente, loading } = useAuth();

  const {
    data: appuntamenti,
    isLoading,
    isError,
    error,
  } = useQuery({
    queryKey: ["appuntamenti"],
    queryFn: api.appuntamenti,
    enabled: !!paziente,
  });

  if (loading) {
    return <Centered text="Caricamento…" />;
  }

  if (!paziente) {
    return (
      <Centered>
        <p className="text-heading/70">Devi accedere per vedere quest&apos;area.</p>
        <Link
          href="/login"
          className="mt-4 inline-flex rounded-full bg-primary px-6 py-3 font-medium text-white transition hover:bg-primary-dark"
        >
          Vai al login
        </Link>
      </Centered>
    );
  }

  return (
    <section className="mx-auto max-w-3xl px-6 py-14">
      <h1 className="font-display text-3xl font-bold text-heading">
        Ciao, {paziente.nome} 👋
      </h1>
      <p className="mt-1 text-heading/70">I tuoi appuntamenti</p>

      <div className="mt-8">
        {isLoading && <p className="text-heading/60">Caricamento appuntamenti…</p>}
        {isError && (
          <p className="text-heading/60">
            {error instanceof ApiError
              ? error.message
              : "Errore nel caricamento."}
          </p>
        )}
        {appuntamenti && appuntamenti.length === 0 && (
          <p className="text-heading/60">
            Non hai ancora appuntamenti.{" "}
            <Link href="/prenota" className="text-primary underline">
              Prenota una visita
            </Link>
            .
          </p>
        )}
        {appuntamenti && appuntamenti.length > 0 && (
          <ul className="space-y-4">
            {appuntamenti.map((a) => (
              <AppuntamentoRow key={a.id} a={a} />
            ))}
          </ul>
        )}
      </div>
    </section>
  );
}

function Centered({
  text,
  children,
}: {
  text?: string;
  children?: React.ReactNode;
}) {
  return (
    <div className="mx-auto flex max-w-md flex-col items-center px-6 py-24 text-center">
      {text && <p className="text-heading/60">{text}</p>}
      {children}
    </div>
  );
}
