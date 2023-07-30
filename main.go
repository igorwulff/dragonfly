package main

import (
	"fmt"
	"net/http"

	"github.com/go-chi/chi/v5"
	"github.com/go-chi/chi/v5/middleware"
	"github.com/go-chi/cors"
	"github.com/igorwulff/dragonfly/modules/cms"
	"github.com/igorwulff/dragonfly/modules/contact"
	"github.com/igorwulff/dragonfly/modules/error"
	"github.com/igorwulff/dragonfly/modules/faq"
)

// https://www.youtube.com/watch?v=LvgVSSpwND8
func main() {
	r := chi.NewRouter()
	r.Use(middleware.RequestID)
	r.Use(middleware.RealIP)
	r.Use(middleware.Recoverer)

	cors := cors.New(cors.Options{
		AllowedOrigins:   []string{"*"},
		AllowedMethods:   []string{"GET", "POST", "PUT", "DELETE", "PATCH", "OPTIONS"},
		AllowedHeaders:   []string{"Accept", "Authorization", "Content-Type", "X-CSRF-Token"},
		AllowCredentials: true,
		MaxAge:           300, // Maximum value not ignored by any of major browsers
	})
	r.Use(cors.Handler)

	cms.InitRouter(r)
	faq.InitRouter(r)
	contact.InitRouter(r)
	error.InitRouter(r)

	fmt.Println("Starting the server on :3000...")
	http.ListenAndServe(":3000", r)
}
