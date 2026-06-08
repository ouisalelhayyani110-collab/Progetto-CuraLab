"use client";

import { useRef } from "react";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";

interface RevealProps {
  children: React.ReactNode;
  className?: string;
  /** stagger delay in seconds */
  delay?: number;
  /** vertical travel in px */
  y?: number;
}

/**
 * Fade + slide-up on mount using GSAP. Runs in a layout effect (useGSAP) so the
 * "from" state is applied before paint — no flash. Honours prefers-reduced-motion,
 * and if JS never runs the content simply stays visible (progressive enhancement).
 */
export default function Reveal({ children, className, delay = 0, y = 24 }: RevealProps) {
  const ref = useRef<HTMLDivElement>(null);

  useGSAP(
    () => {
      const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
      if (reduce) return;
      gsap.fromTo(
        ref.current,
        { opacity: 0, y },
        { opacity: 1, y: 0, duration: 0.6, delay, ease: "power2.out" },
      );
    },
    { scope: ref },
  );

  return (
    <div ref={ref} className={className}>
      {children}
    </div>
  );
}
