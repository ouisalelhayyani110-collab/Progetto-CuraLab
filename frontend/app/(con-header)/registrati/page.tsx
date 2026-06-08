"use client";

import Link from "next/link";
import { useRouter } from "next/navigation";
import { useState } from "react";
import { useAuth } from "@/lib/auth";
import { ApiError } from "@/lib/api";

export default function RegistratiPage() {
  const router = useRouter();
  const { register } = useAuth();
  const [form, setForm] = useState({
    nome: "",
    cognome: "",
    email: "",
    password: "",
    password_confirmation: "",
    consenso_termini: false,
    consenso_privacy: false,
  });
  const [errors, setErrors] = useState<Record<string, string[]>>({});
  const [generalError, setGeneralError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  const onSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setErrors({});
    setGeneralError(null);
    try {
      await register(form);
      router.push("/area-personale");
    } catch (err) {
      if (err instanceof ApiError) {
        setErrors(err.fieldErrors);
        if (Object.keys(err.fieldErrors).length === 0) {
          setGeneralError(err.message);
        }
      } else {
        setGeneralError("Registrazione non riuscita. Riprova.");
      }
    } finally {
      setLoading(false);
    }
  };

  const field =
    "w-full rounded-xl bg-primary/15 px-4 py-3 text-sm text-heading outline-none focus:ring-2 focus:ring-primary";

  const fieldError = (name: string) =>
    errors[name] ? (
      <p id={`err-${name}`} role="alert" className="mt-1 text-xs text-red-700">
        {errors[name][0]}
      </p>
    ) : null;

  const aria = (name: string) => ({
    "aria-invalid": !!errors[name],
    "aria-describedby": errors[name] ? `err-${name}` : undefined,
  });

  return (
    <section className="brand-gradient">
      <div className="mx-auto max-w-md px-6 py-16 sm:py-20">
        <div className="rounded-3xl bg-white p-8 shadow-lg sm:p-10">
          <h1 className="text-center font-display text-2xl font-bold text-heading">
            Crea il tuo account
          </h1>

          <form onSubmit={onSubmit} className="mt-8 space-y-4" noValidate>
            <div className="grid grid-cols-2 gap-3">
              <div>
                <label htmlFor="reg-nome" className="mb-1 block text-sm font-semibold text-heading">
                  Nome
                </label>
                <input
                  id="reg-nome"
                  className={field}
                  autoComplete="given-name"
                  required
                  value={form.nome}
                  onChange={(e) => setForm({ ...form, nome: e.target.value })}
                  {...aria("nome")}
                />
                {fieldError("nome")}
              </div>
              <div>
                <label htmlFor="reg-cognome" className="mb-1 block text-sm font-semibold text-heading">
                  Cognome
                </label>
                <input
                  id="reg-cognome"
                  className={field}
                  autoComplete="family-name"
                  required
                  value={form.cognome}
                  onChange={(e) => setForm({ ...form, cognome: e.target.value })}
                  {...aria("cognome")}
                />
                {fieldError("cognome")}
              </div>
            </div>

            <div>
              <label htmlFor="reg-email" className="mb-1 block text-sm font-semibold text-heading">
                Email
              </label>
              <input
                id="reg-email"
                className={field}
                type="email"
                autoComplete="email"
                required
                value={form.email}
                onChange={(e) => setForm({ ...form, email: e.target.value })}
                {...aria("email")}
              />
              {fieldError("email")}
            </div>

            <div>
              <label htmlFor="reg-password" className="mb-1 block text-sm font-semibold text-heading">
                Password
              </label>
              <input
                id="reg-password"
                className={field}
                type="password"
                autoComplete="new-password"
                required
                value={form.password}
                onChange={(e) => setForm({ ...form, password: e.target.value })}
                {...aria("password")}
              />
              {fieldError("password")}
            </div>

            <div>
              <label htmlFor="reg-password2" className="mb-1 block text-sm font-semibold text-heading">
                Conferma password
              </label>
              <input
                id="reg-password2"
                className={field}
                type="password"
                autoComplete="new-password"
                required
                value={form.password_confirmation}
                onChange={(e) =>
                  setForm({ ...form, password_confirmation: e.target.value })
                }
              />
            </div>

            <label className="flex items-start gap-2 text-sm text-heading/80">
              <input
                type="checkbox"
                className="mt-1 accent-primary"
                required
                checked={form.consenso_termini}
                onChange={(e) =>
                  setForm({ ...form, consenso_termini: e.target.checked })
                }
                {...aria("consenso_termini")}
              />
              Accetto i termini e le condizioni del servizio.
            </label>
            {fieldError("consenso_termini")}

            <label className="flex items-start gap-2 text-sm text-heading/80">
              <input
                type="checkbox"
                className="mt-1 accent-primary"
                required
                checked={form.consenso_privacy}
                onChange={(e) =>
                  setForm({ ...form, consenso_privacy: e.target.checked })
                }
                {...aria("consenso_privacy")}
              />
              Accetto l&apos;informativa sulla privacy.
            </label>
            {fieldError("consenso_privacy")}

            {generalError && (
              <p role="alert" className="rounded-lg bg-red-50 px-4 py-2 text-sm text-red-700">
                {generalError}
              </p>
            )}

            <button
              type="submit"
              disabled={loading}
              className="w-full rounded-xl bg-primary px-6 py-3 font-medium text-white transition hover:bg-primary-dark disabled:opacity-60"
            >
              {loading ? "Creazione…" : "Registrati"}
            </button>
          </form>

          <p className="mt-6 text-center text-sm text-heading/70">
            Hai già un account?{" "}
            <Link href="/login" className="font-semibold text-primary underline">
              Accedi
            </Link>
          </p>
        </div>
      </div>
    </section>
  );
}
