"use client";

import Link from "next/link";
import { useSearchParams } from "next/navigation";
import Carousel from "@/app/_components/ui/carousel";
import type { Medico } from "@/lib/types";

function initials(m: Medico) {
  return `${m.nome.charAt(0)}${m.cognome.charAt(0)}`.toUpperCase();
}

function MedicoCard({ m }: { m: Medico }) {
  return (
    <article className="flex w-72 shrink-0 snap-start flex-col rounded-3xl bg-white p-6 pt-0 shadow-sm ring-1 ring-primary/10">
      <div className="-mt-10 mb-4 flex justify-center">
        <div className="flex h-20 w-20 items-center justify-center rounded-full bg-primary text-2xl font-bold text-white shadow ring-4 ring-white">
          {m.foto ? (
            // eslint-disable-next-line @next/next/no-img-element
            <img
              src={m.foto}
              alt={`Foto di ${m.nome} ${m.cognome}`}
              className="h-full w-full rounded-full object-cover"
            />
          ) : (
            <span aria-hidden>{initials(m)}</span>
          )}
        </div>
      </div>
      <h3 className="text-center font-display text-lg font-bold text-heading">
        {m.nome} {m.cognome}
      </h3>
      <p className="mt-1 text-center text-xs font-semibold uppercase tracking-wider text-primary">
        {m.specializzazione?.nome ?? "Specialista"}
      </p>
      <p className="mt-3 flex-1 text-center text-sm leading-relaxed text-heading/70">
        {m.biografia}
      </p>
      <Link
        href={`/prenota?medico=${m.id}`}
        className="mt-5 inline-flex justify-center rounded-full bg-primary px-5 py-2 text-sm font-medium text-white transition hover:bg-primary-dark"
      >
        Prenota con {m.nome}
      </Link>
    </article>
  );
}

export default function MediciCarousel({ medici }: { medici: Medico[] }) {
  const spec = useSearchParams().get("spec");
  const filtered = spec
    ? medici.filter((m) => m.specializzazione?.nome === spec)
    : medici;

  return (
    <div>
      {spec && (
        <p className="mb-4 text-center text-sm text-heading/70">
          Filtrato per: <strong>{spec}</strong>
        </p>
      )}
      {filtered.length === 0 ? (
        <p className="py-10 text-center text-heading/60">Nessun medico trovato.</p>
      ) : (
        <Carousel ariaLabel="Elenco dei medici">
          {filtered.map((m) => (
            <MedicoCard key={m.id} m={m} />
          ))}
        </Carousel>
      )}
    </div>
  );
}
