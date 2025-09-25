"use server"

import { clientSignIn, clientSignOut } from "App/lib/auth-client"

export async function clientAuth(email, password) {
    const result = await clientSignIn("laravel-client", {
        email,
        password,
        redirectTo: "/client/dashboard",
    })

    return result
}

export async function clientLogout() {
    await clientSignOut({ redirectTo: "/client" })
}
