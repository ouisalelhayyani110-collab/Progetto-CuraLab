"use client";

import { useRouter } from "next/navigation";
import { useState } from "react";
import type { Sede } from "@/lib/types";

export default function SearchBar({
  specializzazioni,
  sedi,
}: {
  specializzazioni: string[];
  sedi: Sede[];
}) {
  const router = useRouter();
  const [spec, setSpec] = useState("");
  const [sede, setSede] = useState("");

  const onSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const params = new URLSearchParams();
    if (spec) params.set("spec", spec);
    const qs = params.toString();
    router.push(`/medici${qs ? `?${qs}` : ""}`);
  };

  return (
    <form
      onSubmit={onSubmit}
      className="grid gap-3 rounded-2xl bg-white p-4 shadow-lg ring-1 ring-primary/10 sm:grid-cols-[1fr_1fr_auto]"
    >
      <select
        value={spec}
        onChange={(e) => setSpec(e.target.value)}
        className="rounded-xl border border-primary/20 bg-mint-soft px-4 py-3 text-sm text-heading outline-none focus:border-primary"
        aria-label="Tipo di medico"
      >
        <option value="">es. tipo di medico</option>
        {specializzazioni.map((s) => (
          <option key={s} value={s}>
            {s}
          </option>
        ))}
      </select>

      <select
        value={sede}
        onChange={(e) => setSede(e.target.value)}
        className="rounded-xl border border-primary/20 bg-mint-soft px-4 py-3 text-sm text-heading outline-none focus:border-primary"
        aria-label="Sede"
      >
        <option value="">es. sede</option>
        {sedi.map((s) => (
          <option key={s.id} value={s.id}>
            {s.nome} — {s.citta}
          </option>
        ))}
      </select>

      <button
        type="submit"
        className="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3 font-medium text-white transition hover:bg-primary-dark"
      >
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
          <circle cx="11" cy="11" r="7" stroke="currentColor" strokeWidth="2" />
          <path d="M21 21l-4-4" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
        </svg>
        Cerca
      </button>
    </form>
  );
}
