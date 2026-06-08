"use client";

import {
  createContext,
  useCallback,
  useContext,
  useEffect,
  useState,
} from "react";
import { api, tokenStore } from "./api";
import type { LoginPayload, Paziente, RegisterPayload } from "./types";

interface AuthContextValue {
  paziente: Paziente | null;
  loading: boolean;
  login: (p: LoginPayload) => Promise<void>;
  register: (p: RegisterPayload) => Promise<void>;
  logout: () => Promise<void>;
}

const AuthContext = createContext<AuthContextValue | null>(null);

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const [paziente, setPaziente] = useState<Paziente | null>(null);
  const [loading, setLoading] = useState(true);

  // On first load, if we have a stored token, hydrate the current patient.
  // Syncing React state from localStorage (an external system) on mount is
  // exactly what an effect is for here.
  useEffect(() => {
    const token = tokenStore.get();
    if (!token) {
      // eslint-disable-next-line react-hooks/set-state-in-effect
      setLoading(false);
      return;
    }
    api
      .me()
      .then(setPaziente)
      .catch(() => tokenStore.clear())
      .finally(() => setLoading(false));
  }, []);

  const login = useCallback(async (p: LoginPayload) => {
    const res = await api.login(p);
    tokenStore.set(res.token);
    setPaziente(res.paziente);
  }, []);

  const register = useCallback(async (p: RegisterPayload) => {
    const res = await api.register(p);
    tokenStore.set(res.token);
    setPaziente(res.paziente);
  }, []);

  const logout = useCallback(async () => {
    try {
      await api.logout();
    } catch {
      // ignore network/401 — clear locally regardless
    }
    tokenStore.clear();
    setPaziente(null);
  }, []);

  return (
    <AuthContext.Provider value={{ paziente, loading, login, register, logout }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const ctx = useContext(AuthContext);
  if (!ctx) throw new Error("useAuth must be used within <AuthProvider>");
  return ctx;
}
