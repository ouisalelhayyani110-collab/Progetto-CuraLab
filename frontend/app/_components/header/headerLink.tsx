"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";

interface HeaderLinkProps {
  label: string;
  href: string;
}

export default function HeaderLink({ label, href }: HeaderLinkProps) {
  const pathname = usePathname();
  const active =
    href === "/" ? pathname === "/" : pathname.startsWith(href);

  return (
    <Link
      href={href}
      className={`px-1 text-sm font-medium text-white transition hover:opacity-100 sm:text-base ${
        active ? "underline underline-offset-4 opacity-100" : "opacity-90"
      }`}
    >
      {label}
    </Link>
  );
}
