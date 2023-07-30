package contact

import (
	"github.com/go-chi/chi/v5"
	"github.com/igorwulff/dragonfly/framework"
	"github.com/igorwulff/dragonfly/templates"
)

func InitRouter(r *chi.Mux) {
	tplContactForm := framework.Must(framework.ParseFS(templates.FS, "contact/form.gohtml", "layout/*"))
	r.Get("/contact/{id:[0-9]+}/edit", framework.StaticHandler(tplContactForm))

	tplContact := framework.Must(framework.ParseFS(templates.FS, "contact/index.gohtml", "layout/*"))
	r.Get("/contact", framework.StaticHandler(tplContact))
}
