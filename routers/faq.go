package routers

import (
	"github.com/go-chi/chi/v5"
	"github.com/igorwulff/dragonfly/controllers"
	"github.com/igorwulff/dragonfly/databases"
	"github.com/igorwulff/dragonfly/templates"
	"github.com/igorwulff/dragonfly/views"
)

func InitFaqRouter(r *chi.Mux) {
	NamesStartingWith()

	tplFaq := views.Must(views.ParseFS(templates.FS, "faq/index.gohtml", "layout/*"))
	r.Get("/faq", controllers.FAQ(tplFaq))
}
