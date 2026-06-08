import Link from "next/link";

export default function Logo({
  variant = "dark",
}: {
  variant?: "light" | "dark";
}) {
  const isLight = variant === "light";
  return (
    <Link href="/" className="flex items-center gap-2.5" aria-label="CuraLab — home">
      <svg
        width="38"
        height="38"
        viewBox="0 0 40 40"
        fill="none"
        aria-hidden="true"
      >
        <rect
          x="15"
          y="4"
          width="10"
          height="32"
          rx="5"
          fill={isLight ? "#ffffff" : "#5fb8b8"}
        />
        <rect
          x="4"
          y="15"
          width="32"
          height="10"
          rx="5"
          fill={isLight ? "#99d9d9" : "#3e9b9b"}
        />
      </svg>
      <span className="leading-tight">
        <span
          className={`block font-display text-2xl font-bold ${
            isLight ? "text-white" : "text-primary-dark"
          }`}
        >
          CuraLab
        </span>
        <span
          className={`block text-[11px] tracking-wide ${
            isLight ? "text-white/80" : "text-primary"
          }`}
        >
          Il tuo spazio di salute
        </span>
      </span>
    </Link>
  );
}
