import Credentials from "next-auth/providers/credentials"

export const adminAuthConfig = {
	secret: process.env.NEXTAUTH_SECRET,
	basePath: "/api/admin/auth",
	session: { strategy: "jwt", maxAge: 60 * 60 * 24 * 365 }, // 365j
	cookies: {
		sessionToken: {
			name: "admin.session-token",
			options: {
				httpOnly: true,
				sameSite: "lax",
				path: "/",
				secure: process.env.NODE_ENV === "production"
			}
		}
	},
	providers: [
		Credentials({
			id: "laravel-admin",
			name: "Email & Password",
			credentials: { email: {}, password: {} },
			async authorize(credentials) {
				const res = await fetch(`${process.env.BACKEND_URL}/admin/auth/login`, {
					method: "POST",
					headers: { "Content-Type": "application/json" },
					body: JSON.stringify({
						email: credentials?.email,
						password: credentials?.password
					})
				})
				if (!res.ok) return null
				const data = await res.json()
				const admin = data.data
				return {
					id: admin.id.toString(),
					name: admin.name,
					email: admin.email,
					laravelAccessToken: data.token,
					userType: 'admin',
					role: admin.role,
					canUpdatePrice: admin.permissions.includes('products.update_price'),
				}
			}
		})
	],
	callbacks: {
		async jwt({ token, user }) {
			if (user) {
				token.role = user.role
				token.userType = user.userType
				token.laravelAccessToken = user.laravelAccessToken
				token.canUpdatePrice = user.canUpdatePrice
			}
			return token
		},
		async session({ session, token }) {
			session.user.role = token.role
			session.user.userType = token.userType
			session.user.laravelAccessToken = token.laravelAccessToken
			session.user.canUpdatePrice = token.canUpdatePrice
			return session
		},
		// Utilisé par le middleware pour protéger les routes admin
		authorized: async ({ auth }) => !!auth && auth.user?.userType === "admin"
	},
	events: {
		signOut: async ({ token }) => {
			if (token?.laravelAccessToken) {
				try {
					await fetch(`${process.env.BACKEND_URL}/admin/logout`, {
						method: "POST",
						headers: {
							Authorization: `Bearer ${token.laravelAccessToken}`,
							"Content-Type": "application/json"
						}
					})

					return true
				} catch (err) {
					console.error("Erreur logout Laravel :", err)
				}
			}
		}
	}
}
