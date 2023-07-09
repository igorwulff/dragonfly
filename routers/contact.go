package routers

import (
	"github.com/go-chi/chi/v5"
	"github.com/igorwulff/dragonfly/controllers"
	"github.com/igorwulff/dragonfly/templates"
	"github.com/igorwulff/dragonfly/views"
)

func InitContactRouter(r *chi.Mux) {
	tplContactForm := views.Must(views.ParseFS(templates.FS, "contact/form.gohtml", "layout/*"))
	r.Get("/contact/{id:[0-9]+}/edit", controllers.StaticHandler(tplContactForm))

	tplContact := views.Must(views.ParseFS(templates.FS, "contact/index.gohtml", "layout/*"))
	r.Get("/contact", controllers.StaticHandler(tplContact))
}
