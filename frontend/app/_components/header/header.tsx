"use client";

import Link from "next/link";
import { useState } from "react";
import { usePathname } from "next/navigation";
import Logo from "../logo";
import HeaderLink from "./headerLink";
import { useAuth } from "@/lib/auth";

const baseLinks = [
  { label: "Home", href: "/" },
  { label: "Chi siamo", href: "/chi-siamo" },
  { label: "Medici", href: "/medici" },
  { label: "Servizi", href: "/servizi" },
];

export default function Header() {
  const { paziente, logout } = useAuth();
  const pathname = usePathname();
  const [open, setOpen] = useState(false);

  const navItems = [
    ...baseLinks,
    paziente
      ? { label: "Area personale", href: "/area-personale" }
      : { label: "Login", href: "/login" },
  ];

  const isActive = (href: string) =>
    href === "/" ? pathname === "/" : pathname.startsWith(href);

  return (
    <header className="brand-gradient sticky top-0 z-50 shadow-sm">
      <div className="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-3 sm:px-8">
        <Logo variant="light" />

        {/* Desktop nav */}
        <nav className="hidden items-center md:flex" aria-label="Navigazione principale">
          {navItems.map((item, i) => (
            <span key={item.href} className="flex items-center">
              {i > 0 && (
                <span className="px-1 text-white/40 sm:px-2" aria-hidden>
                  |
                </span>
              )}
              <HeaderLink label={item.label} href={item.href} />
            </span>
          ))}
          {paziente && (
            <button
              type="button"
              onClick={() => logout()}
              className="ml-3 rounded-full bg-white/15 px-3 py-1 text-sm font-medium text-white transition hover:bg-white/25"
            >
              Esci
            </button>
          )}
        </nav>

        {/* Mobile toggle */}
        <button
          type="button"
          className="rounded-lg p-2 text-white transition hover:bg-white/15 md:hidden"
          aria-expanded={open}
          aria-controls="mobile-menu"
          aria-label={open ? "Chiudi menu" : "Apri menu"}
          onClick={() => setOpen((v) => !v)}
        >
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" aria-hidden>
            {open ? (
              <path
                d="M6 6l12 12M18 6L6 18"
                stroke="currentColor"
                strokeWidth="2"
                strokeLinecap="round"
              />
            ) : (
              <path
                d="M4 7h16M4 12h16M4 17h16"
                stroke="currentColor"
                strokeWidth="2"
                strokeLinecap="round"
              />
            )}
          </svg>
        </button>
      </div>

      {/* Mobile menu */}
      <nav
        id="mobile-menu"
        aria-label="Navigazione principale"
        className={`overflow-hidden border-white/20 bg-primary-dark md:hidden ${
          open ? "block border-t" : "hidden"
        }`}
      >
        <ul className="flex flex-col px-5 py-2">
          {navItems.map((item) => (
            <li key={item.href}>
              <Link
                href={item.href}
                onClick={() => setOpen(false)}
                aria-current={isActive(item.href) ? "page" : undefined}
                className={`block rounded-lg px-2 py-3 font-medium text-white transition hover:bg-white/10 ${
                  isActive(item.href) ? "underline underline-offset-4" : ""
                }`}
              >
                {item.label}
              </Link>
            </li>
          ))}
          {paziente && (
            <li>
              <button
                type="button"
                onClick={() => {
                  logout();
                  setOpen(false);
                }}
                className="block w-full rounded-lg px-2 py-3 text-left font-medium text-white transition hover:bg-white/10"
              >
                Esci
              </button>
            </li>
          )}
        </ul>
      </nav>
    </header>
  );
}
