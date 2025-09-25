"use client"

import { useState } from "react"
import { clientAuth } from "../../server/clientAuth"
import { redirect } from "next/navigation"

export default function ClientLoginPage() {
    const [email, setEmail] = useState("user@pharma-gdd.com")
    const [password, setPassword] = useState("")
    const [isLoading, setIsLoading] = useState(false)
    const [error, setError] = useState("")

    const handleSubmit = async (e) => {
        e.preventDefault()
        setIsLoading(true)
        setError("")

        try {
            const result = await clientAuth(email, password)

            if (result?.error) {
                setError("Email ou mot de passe incorrect")
            } else {
                // Redirection sera gérée par le middleware
                redirect("/client/dashboard")
            }
        } catch (err) {
            setError("Erreur de connexion")
            console.error("Erreur login client:", err)
        } finally {
            setIsLoading(false)
        }
    }

    return (
        <div className="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
            <div className="sm:mx-auto sm:w-full sm:max-w-sm">
              <h2 className="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Sign in to your account</h2>
            </div>

            <div className="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
              <form action="#" method="POST" onSubmit={handleSubmit} className="space-y-6">
                {error && (
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                      <span class="block sm:inline">{error}</span>
                      <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                      </span>
                    </div>
                )}
                <div>
                  <label htmlFor="email" className="block text-sm/6 font-medium text-gray-100">
                    Email address
                  </label>
                  <div className="mt-2">
                    <input
                      id="email"
                      name="email"
                      type="email"
                      required
                      autoComplete="email"
                      className="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                      value={email}
                      onChange={(e) => setEmail(e.target.value)}
                    />
                  </div>
                </div>

                <div>
                  <div className="mt-2">
                    <input
                      id="password"
                      name="password"
                      type="password"
                      required
                      autoComplete="current-password"
                      className="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                      value={password}
                      onChange={(e) => setPassword(e.target.value)}
                    />
                  </div>
                </div>

                <div>
                <button
                    type="submit"
                    disabled={isLoading}
                    className="cursor-pointer flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                >
                    {isLoading ? "Connexion..." : "Se connecter"}
                </button>
                </div>
              </form>
            </div>
        </div>
    )
}
