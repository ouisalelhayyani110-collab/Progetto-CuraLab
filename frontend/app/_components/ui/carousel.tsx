"use client";

import { useRef } from "react";

export default function Carousel({
  children,
  ariaLabel = "Contenuti scorrevoli",
}: {
  children: React.ReactNode;
  ariaLabel?: string;
}) {
  const ref = useRef<HTMLDivElement>(null);

  const scroll = (dir: -1 | 1) => {
    const el = ref.current;
    if (!el) return;
    el.scrollBy({ left: dir * el.clientWidth * 0.8, behavior: "smooth" });
  };

  const onKeyDown = (e: React.KeyboardEvent) => {
    if (e.key === "ArrowRight") {
      e.preventDefault();
      scroll(1);
    } else if (e.key === "ArrowLeft") {
      e.preventDefault();
      scroll(-1);
    }
  };

  return (
    <div className="relative px-2 sm:px-14">
      <ArrowButton dir="left" onClick={() => scroll(-1)} />
      <div
        ref={ref}
        role="region"
        aria-label={ariaLabel}
        tabIndex={0}
        onKeyDown={onKeyDown}
        className="no-scrollbar flex snap-x snap-mandatory gap-6 overflow-x-auto scroll-smooth rounded-2xl py-4"
      >
        {children}
      </div>
      <ArrowButton dir="right" onClick={() => scroll(1)} />
    </div>
  );
}

function ArrowButton({
  dir,
  onClick,
}: {
  dir: "left" | "right";
  onClick: () => void;
}) {
  return (
    <button
      type="button"
      onClick={onClick}
      aria-label={dir === "left" ? "Scorri indietro" : "Scorri avanti"}
      className={`absolute top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border-2 border-primary bg-white/90 text-primary-dark shadow-sm backdrop-blur transition hover:scale-110 hover:bg-primary hover:text-white active:scale-100 ${
        dir === "left" ? "left-0" : "right-0"
      }`}
    >
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden>
        <path
          d={dir === "left" ? "M15 6l-6 6 6 6" : "M9 6l6 6-6 6"}
          stroke="currentColor"
          strokeWidth="2.5"
          strokeLinecap="round"
          strokeLinejoin="round"
        />
      </svg>
    </button>
  );
}
