export function CardSkeleton() {
  return (
    <div className="w-72 shrink-0 animate-pulse rounded-3xl bg-white p-6 shadow-sm ring-1 ring-primary/10">
      <div className="mx-auto mb-4 h-20 w-20 rounded-full bg-mint" />
      <div className="mx-auto h-4 w-32 rounded bg-mint" />
      <div className="mx-auto mt-2 h-3 w-20 rounded bg-mint" />
      <div className="mt-4 space-y-2">
        <div className="h-3 rounded bg-mint" />
        <div className="h-3 rounded bg-mint" />
        <div className="h-3 w-2/3 rounded bg-mint" />
      </div>
    </div>
  );
}

export function CardSkeletonRow({ count = 3 }: { count?: number }) {
  return (
    <div
      className="flex gap-6 overflow-hidden px-2 py-4 sm:px-14"
      aria-hidden="true"
    >
      {Array.from({ length: count }).map((_, i) => (
        <CardSkeleton key={i} />
      ))}
    </div>
  );
}
