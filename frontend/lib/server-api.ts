import type { Medico, Servizio, Sede } from "./types";

// Server-side data layer for public content. Uses Next's fetch cache (ISR) so
// pages render as static HTML and revalidate periodically. Failures fall back to
// an empty list so a build with the API offline still succeeds (renders the empty
// state and repopulates on the next revalidation).

const BASE_URL =
  process.env.NEXT_PUBLIC_API_BASE_URL ?? "http://localhost:8000/api";

const REVALIDATE_SECONDS = 3600;

async function getJson<T>(path: string, fallback: T): Promise<T> {
  try {
    const res = await fetch(`${BASE_URL}${path}`, {
      headers: { Accept: "application/json" },
      next: { revalidate: REVALIDATE_SECONDS },
    });
    if (!res.ok) return fallback;
    return (await res.json()) as T;
  } catch {
    return fallback;
  }
}

export const serverApi = {
  medici: () => getJson<Medico[]>("/medici", []),
  servizi: () => getJson<Servizio[]>("/servizi", []),
  sedi: () => getJson<Sede[]>("/sedi", []),
};
