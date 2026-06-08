import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { serverApi } from "@/lib/server-api";
import ContactForm from "@/app/_components/contatti/contactForm";

export const metadata: Metadata = {
  title: "Contatti — CuraLab",
  description: "Contatta CuraLab: indirizzo, email e telefono delle nostre sedi.",
};

export const revalidate = 3600;

export default async function ContattiPage() {
  const sedi = await serverApi.sedi();
  const sede = sedi[0];

  return (
    <section className="mx-auto max-w-6xl px-6 py-16">
      <div className="grid gap-10 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-primary/10 sm:p-12 lg:grid-cols-2">
        {/* Left: heading + info (server-rendered) */}
        <div>
          <p className="font-medium text-primary">Siamo qui per te !</p>
          <h1 className="mt-1 font-display text-5xl font-bold leading-none text-heading">
            I nostri
            <br />
            contatti
          </h1>
          <div className="mt-4 h-1 w-16 rounded bg-primary" />

          <dl className="mt-8 space-y-5 text-sm">
            <div>
              <dt className="font-display font-semibold text-heading">Indirizzo</dt>
              <dd className="text-heading/70">
                {sede ? `${sede.indirizzo}, ${sede.cap ?? ""} ${sede.citta}` : "—"}
              </dd>
            </div>
            <div>
              <dt className="font-display font-semibold text-heading">Email</dt>
              <dd className="text-heading/70">{sede?.email ?? "—"}</dd>
            </div>
            <div>
              <dt className="font-display font-semibold text-heading">
                Numero di telefono
              </dt>
              <dd className="text-heading/70">{sede?.telefono ?? "—"}</dd>
            </div>
          </dl>

          <Link
            href="/prenota"
            className="mt-8 inline-flex items-center rounded-full bg-primary px-7 py-3 font-medium text-white transition hover:bg-primary-dark"
          >
            Prenota ora!
          </Link>

          <div className="relative mt-8 hidden h-44 overflow-hidden rounded-2xl lg:block">
            <Image
              src="https://picsum.photos/seed/curalab-doctor/900/500"
              alt=""
              fill
              sizes="50vw"
              className="object-cover"
            />
          </div>
        </div>

        {/* Right: contact form (client) */}
        <ContactForm />
      </div>
    </section>
  );
}
