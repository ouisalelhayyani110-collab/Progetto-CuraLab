import type { Metadata } from "next";
import Image from "next/image";

export const metadata: Metadata = {
  title: "Chi siamo — CuraLab",
};

export default function ChiSiamoPage() {
  return (
    <section className="brand-gradient">
      <div className="mx-auto grid max-w-6xl items-center gap-10 px-6 py-16 sm:py-24 lg:grid-cols-2">
        <div className="text-white">
          <h1 className="font-display text-4xl font-bold sm:text-5xl">Chi siamo</h1>
          <p className="mt-2 text-lg text-white/85">
            La tua salute, seguita con metodo.
          </p>

          <div className="mt-8 space-y-5 leading-relaxed text-white/95">
            <p>
              CuraLab è uno spazio dedicato alla salute e al benessere, dove
              competenza medica e attenzione alla persona si incontrano. Offriamo
              percorsi di cura personalizzati, basati sull&apos;ascolto, sulla
              prevenzione e sulla fiducia.
            </p>
            <p>
              Il nostro team di professionisti lavora ogni giorno per garantire
              qualità, affidabilità e un&apos;esperienza accogliente, mettendo
              sempre il paziente al centro.
            </p>
          </div>
        </div>

        <div className="relative h-72 overflow-hidden rounded-3xl shadow-lg sm:h-96">
          <Image
            src="https://picsum.photos/seed/curalab-team/900/900"
            alt="Il team di professionisti CuraLab"
            fill
            sizes="(max-width: 1024px) 100vw, 50vw"
            className="object-cover"
          />
        </div>
      </div>
    </section>
  );
}
