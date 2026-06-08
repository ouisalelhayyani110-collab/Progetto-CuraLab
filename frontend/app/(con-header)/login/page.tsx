"use client";

import Image from "next/image";
import Link from "next/link";
import { useRouter } from "next/navigation";
import { useState } from "react";
import { useAuth } from "@/lib/auth";
import { ApiError } from "@/lib/api";

export default function LoginPage() {
  const router = useRouter();
  const { login } = useAuth();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);
  const [showForgot, setShowForgot] = useState(false);

  const onSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError(null);
    try {
      await login({ email, password });
      router.push("/area-personale");
    } catch (err) {
      setError(
        err instanceof ApiError
          ? err.message
          : "Accesso non riuscito. Riprova.",
      );
    } finally {
      setLoading(false);
    }
  };

  const field =
    "w-full rounded-xl bg-primary/15 px-4 py-3 text-sm text-heading outline-none focus:ring-2 focus:ring-primary";

  return (
    <section className="relative isolate">
      <Image
        src="https://picsum.photos/seed/curalab-login/1600/1000"
        alt=""
        fill
        priority
        sizes="100vw"
        className="-z-10 object-cover"
      />
      <div className="absolute inset-0 -z-10 brand-gradient opacity-90" />

      <div className="mx-auto flex max-w-md items-center px-6 py-16 sm:py-24">
        <div className="w-full rounded-3xl bg-white p-8 shadow-lg sm:p-10">
          <h1 className="text-center font-display text-2xl font-bold text-heading">
            Accedi al tuo profilo
          </h1>

          <form onSubmit={onSubmit} className="mt-8 space-y-5" noValidate>
            <div>
              <label
                htmlFor="login-email"
                className="mb-1 block text-sm font-semibold text-heading"
              >
                Email
              </label>
              <input
                id="login-email"
                className={field}
                type="email"
                autoComplete="email"
                required
                aria-invalid={!!error}
                aria-describedby={error ? "login-error" : undefined}
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>

            <div>
              <div className="mb-1 flex items-center justify-between">
                <label
                  htmlFor="login-password"
                  className="text-sm font-semibold text-heading"
                >
                  Password
                </label>
                <button
                  type="button"
                  onClick={() => setShowForgot((v) => !v)}
                  aria-expanded={showForgot}
                  className="text-xs text-primary underline"
                >
                  Password dimenticata?
                </button>
              </div>
              <input
                id="login-password"
                className={field}
                type="password"
                autoComplete="current-password"
                required
                aria-invalid={!!error}
                aria-describedby={error ? "login-error" : undefined}
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />
              {showForgot && (
                <p className="mt-2 text-xs text-heading/60">
                  Il recupero password non è ancora disponibile. Contatta la
                  segreteria dalla pagina{" "}
                  <Link href="/contatti" className="text-primary underline">
                    Contatti
                  </Link>
                  .
                </p>
              )}
            </div>

            {error && (
              <p
                id="login-error"
                role="alert"
                className="rounded-lg bg-red-50 px-4 py-2 text-sm text-red-700"
              >
                {error}
              </p>
            )}

            <button
              type="submit"
              disabled={loading}
              className="w-full rounded-xl bg-primary px-6 py-3 font-medium text-white transition hover:bg-primary-dark disabled:opacity-60"
            >
              {loading ? "Accesso…" : "Login"}
            </button>
          </form>

          <p className="mt-6 text-center text-sm text-heading/70">
            Non ancora un account?{" "}
            <Link href="/registrati" className="font-semibold text-primary underline">
              Registrati
            </Link>
          </p>
        </div>
      </div>
    </section>
  );
}
