import type { Metadata } from "next";
import { Suspense } from "react";
import { serverApi } from "@/lib/server-api";
import MediciCarousel from "@/app/_components/medici/mediciCarousel";

export const metadata: Metadata = {
  title: "Medici — CuraLab",
  description:
    "Incontra il team di medici specialisti di CuraLab: cardiologia, ginecologia, ortopedia e altro.",
};

export const revalidate = 3600;

export default async function MediciPage() {
  const medici = await serverApi.medici();

  return (
    <section className="bg-mint">
      <div className="mx-auto max-w-7xl px-6 py-14">
        <div className="mb-2 flex justify-center">
          <span className="rounded-full bg-white px-4 py-1 text-sm font-medium text-primary-dark shadow-sm">
            Il nostro team
          </span>
        </div>
        <h1 className="text-center font-display text-4xl font-light text-primary-dark sm:text-5xl">
          Incontra i nostri medici
        </h1>

        <div className="mt-10">
          <Suspense
            fallback={<p className="py-10 text-center text-heading/60">Caricamento…</p>}
          >
            <MediciCarousel medici={medici} />
          </Suspense>
        </div>
      </div>
    </section>
  );
}
