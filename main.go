package main

import (
	"fmt"
	"net/http"

	"github.com/go-chi/chi/v5"
	"github.com/go-chi/chi/v5/middleware"
	"github.com/igorwulff/dragonfly/modules/cms"
	"github.com/igorwulff/dragonfly/modules/contact"
	"github.com/igorwulff/dragonfly/modules/error"
	"github.com/igorwulff/dragonfly/modules/faq"
)

// https://www.youtube.com/watch?v=LvgVSSpwND8
func main() {
	r := chi.NewRouter()
	r.Use(middleware.Logger)

	cms.InitRouter(r)
	faq.InitRouter(r)
	contact.InitRouter(r)
	error.InitRouter(r)

	fmt.Println("Starting the server on :3000...")
	http.ListenAndServe(":3000", r)
}
