import Link from "next/link";
import Logo from "../logo";

export default function Footer() {
  return (
    <footer className="mt-20 border-t border-primary/20 bg-white">
      <div className="mx-auto grid max-w-7xl gap-8 px-6 py-12 sm:grid-cols-3">
        <div>
          <Logo variant="dark" />
          <p className="mt-3 max-w-xs text-sm text-heading/70">
            Poliambulatorio a Torino e provincia. La tua salute, sempre al centro.
          </p>
        </div>

        <div>
          <h4 className="mb-3 font-display font-semibold text-primary-dark">
            Naviga
          </h4>
          <ul className="space-y-2 text-sm text-heading/80">
            <li><Link href="/chi-siamo" className="hover:text-primary">Chi siamo</Link></li>
            <li><Link href="/medici" className="hover:text-primary">Medici</Link></li>
            <li><Link href="/servizi" className="hover:text-primary">Servizi</Link></li>
            <li><Link href="/contatti" className="hover:text-primary">Contatti</Link></li>
          </ul>
        </div>

        <div>
          <h4 className="mb-3 font-display font-semibold text-primary-dark">
            Account
          </h4>
          <ul className="space-y-2 text-sm text-heading/80">
            <li><Link href="/login" className="hover:text-primary">Accedi</Link></li>
            <li><Link href="/registrati" className="hover:text-primary">Registrati</Link></li>
            <li><Link href="/area-personale" className="hover:text-primary">Area personale</Link></li>
          </ul>
        </div>
      </div>
      <div className="border-t border-primary/10 py-4 text-center text-xs text-heading/60">
        © {new Date().getFullYear()} CuraLab. Tutti i diritti riservati.
      </div>
    </footer>
  );
}
