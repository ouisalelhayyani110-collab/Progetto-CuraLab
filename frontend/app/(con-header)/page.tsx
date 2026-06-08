import Image from "next/image";
import Link from "next/link";
import SearchBar from "@/app/_components/home/searchBar";
import Reveal from "@/app/_components/ui/reveal";
import { serverApi } from "@/lib/server-api";

const features = [
  {
    href: "/medici",
    title: "I nostri medici",
    text: "Un team di specialisti per ogni esigenza.",
  },
  {
    href: "/servizi",
    title: "I nostri servizi",
    text: "Visite e prestazioni su misura per la tua salute.",
  },
  {
    href: "/contatti",
    title: "Contatti & sedi",
    text: "Cinque sedi a Torino e provincia, sempre vicine a te.",
  },
];

export const revalidate = 3600;

export default async function Home() {
  const [medici, sedi] = await Promise.all([
    serverApi.medici(),
    serverApi.sedi(),
  ]);
  const specializzazioni = Array.from(
    new Set(
      medici
        .map((m) => m.specializzazione?.nome)
        .filter((n): n is string => Boolean(n)),
    ),
  ).sort();

  return (
    <>
      {/* Hero */}
      <section className="relative isolate overflow-hidden text-white">
        <Image
          src="https://picsum.photos/seed/curalab-hero/1600/900"
          alt=""
          fill
          priority
          sizes="100vw"
          className="-z-10 object-cover"
        />
        <div className="absolute inset-0 -z-10 brand-gradient opacity-85" />
        <div className="mx-auto max-w-7xl px-6 py-20 sm:py-28">
          <Reveal>
            <p className="font-display text-xs font-medium uppercase tracking-[0.2em] text-white/90">
              Poliambulatorio · Torino
            </p>
            <h1 className="mt-3 max-w-3xl font-display text-4xl font-bold leading-tight drop-shadow-sm sm:text-6xl">
              Prenota la tua visita!
            </h1>
            <p className="mt-5 max-w-xl text-lg text-white/95">
              Medici specialisti, percorsi personalizzati e un&apos;esperienza di cura
              accogliente. Il paziente sempre al centro.
            </p>
            <div className="mt-8 flex flex-wrap gap-3">
              <Link
                href="/prenota"
                className="inline-flex items-center rounded-full bg-white px-6 py-3 font-medium text-primary-dark shadow-sm transition hover:bg-white/90"
              >
                Prenota una visita
              </Link>
              <Link
                href="/medici"
                className="inline-flex items-center rounded-full border border-white/70 px-6 py-3 font-medium text-white transition hover:bg-white/10"
              >
                Scopri i medici
              </Link>
            </div>
          </Reveal>
        </div>
      </section>

      {/* Search bar overlapping the hero */}
      <section className="mx-auto -mt-8 max-w-5xl px-6">
        <Reveal delay={0.15}>
          <SearchBar specializzazioni={specializzazioni} sedi={sedi} />
        </Reveal>
      </section>

      {/* Feature cards */}
      <section className="mx-auto max-w-7xl px-6 py-16">
        <div className="grid gap-6 sm:grid-cols-3">
          {features.map((f, i) => (
            <Reveal key={f.href} delay={i * 0.1}>
              <Link
                href={f.href}
                className="group block h-full rounded-2xl bg-white p-7 shadow-sm ring-1 ring-primary/10 transition hover:-translate-y-1 hover:shadow-md"
              >
                <h2 className="font-display text-xl font-semibold text-primary-dark">
                  {f.title}
                </h2>
                <p className="mt-2 text-sm text-heading/70">{f.text}</p>
                <span className="mt-4 inline-block text-sm font-medium text-primary transition group-hover:translate-x-1">
                  Scopri →
                </span>
              </Link>
            </Reveal>
          ))}
        </div>
      </section>
    </>
  );
}
