// Maps a specialization name to a line icon. Falls back to a stethoscope.

const common = {
  width: 44,
  height: 44,
  viewBox: "0 0 24 24",
  fill: "none",
  stroke: "currentColor",
  strokeWidth: 1.6,
  strokeLinecap: "round" as const,
  strokeLinejoin: "round" as const,
};

function Heart() {
  return (
    <svg {...common} aria-hidden>
      <path d="M12 20s-7-4.6-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.4-7 10-7 10z" />
      <path d="M7 12h2l1.5-2 2 4 1.5-2H17" />
    </svg>
  );
}

function Stethoscope() {
  return (
    <svg {...common} aria-hidden>
      <path d="M6 3v5a4 4 0 0 0 8 0V3" />
      <path d="M10 16v1a4 4 0 0 0 8 0v-2" />
      <circle cx="18" cy="11" r="2" />
    </svg>
  );
}

function Bone() {
  return (
    <svg {...common} aria-hidden>
      <path d="M7 17a2.2 2.2 0 1 1-2-3 2.2 2.2 0 1 1 3-2l6 6a2.2 2.2 0 1 1 2 3 2.2 2.2 0 1 1-3 2z" />
    </svg>
  );
}

function Dna() {
  return (
    <svg {...common} aria-hidden>
      <path d="M7 4c0 4 10 6 10 10M17 4c0 4-10 6-10 10M7 20c0-4 10-6 10-10M17 20c0-4-10-6-10-10" />
    </svg>
  );
}

const MAP: Record<string, () => React.ReactElement> = {
  Cardiologia: Heart,
  Ginecologia: Dna,
  Ostetricia: Dna,
  Ortopedia: Bone,
  Dermatologia: Dna,
  Neurologia: Dna,
  Pediatria: Stethoscope,
};

export default function ServiceIcon({
  specializzazione,
}: {
  specializzazione?: string;
}) {
  const Icon = (specializzazione && MAP[specializzazione]) || Stethoscope;
  return <Icon />;
}
