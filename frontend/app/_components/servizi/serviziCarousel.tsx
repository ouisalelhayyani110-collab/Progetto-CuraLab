"use client";

import Carousel from "@/app/_components/ui/carousel";
import ServiceIcon from "@/app/_components/servizi/serviceIcon";
import type { Servizio } from "@/lib/types";

function ServizioCard({ s }: { s: Servizio }) {
  return (
    <article className="flex w-80 shrink-0 snap-start flex-col items-center rounded-3xl bg-white p-7 shadow-sm ring-1 ring-primary/10">
      <div className="text-primary">
        <ServiceIcon specializzazione={s.specializzazione?.nome} />
      </div>
      <div className="my-3 h-0.5 w-12 rounded bg-primary/30" />
      <h3 className="text-center font-display text-xl font-bold text-heading">
        {s.nome}
      </h3>
      <p className="mt-4 rounded-2xl bg-mint px-4 py-3 text-center text-sm leading-relaxed text-heading/80">
        {s.descrizione}
      </p>
      <p className="mt-3 text-xs text-heading/60">
        Durata indicativa: {s.durata_default_min} min
      </p>
    </article>
  );
}

export default function ServiziCarousel({ servizi }: { servizi: Servizio[] }) {
  if (servizi.length === 0) {
    return (
      <p className="py-10 text-center text-heading/60">
        Nessun servizio disponibile al momento.
      </p>
    );
  }

  return (
    <Carousel ariaLabel="Elenco dei servizi">
      {servizi.map((s) => (
        <ServizioCard key={s.id} s={s} />
      ))}
    </Carousel>
  );
}
