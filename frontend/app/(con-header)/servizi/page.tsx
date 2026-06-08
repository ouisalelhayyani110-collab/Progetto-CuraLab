import type { Metadata } from "next";
import { serverApi } from "@/lib/server-api";
import ServiziCarousel from "@/app/_components/servizi/serviziCarousel";

export const metadata: Metadata = {
  title: "Servizi — CuraLab",
  description:
    "I servizi e le visite specialistiche di CuraLab, su misura per la tua salute.",
};

export const revalidate = 3600;

export default async function ServiziPage() {
  const servizi = await serverApi.servizi();

  return (
    <section className="bg-mint">
      <div className="mx-auto max-w-7xl px-6 py-14">
        <h1 className="font-display text-3xl font-bold uppercase tracking-wide text-heading sm:text-4xl">
          I nostri servizi
        </h1>
        <p className="mt-1 text-lg text-primary-dark">
          Soluzioni su misura per la tua salute
        </p>

        <div className="mt-10">
          <ServiziCarousel servizi={servizi} />
        </div>
      </div>
    </section>
  );
}
