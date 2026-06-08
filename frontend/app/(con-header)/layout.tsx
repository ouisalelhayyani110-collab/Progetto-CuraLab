import Header from "@/app/_components/header/header";
import Footer from "@/app/_components/footer/footer";

export default function ConHeaderLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <div className="flex min-h-full flex-col">
      <a
        href="#contenuto"
        className="sr-only z-[100] rounded-lg bg-white px-4 py-2 font-medium text-primary-dark shadow focus:not-sr-only focus:absolute focus:left-4 focus:top-4"
      >
        Salta al contenuto
      </a>
      <Header />
      <main id="contenuto" className="flex-1">
        {children}
      </main>
      <Footer />
    </div>
  );
}
