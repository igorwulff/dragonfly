package routers

import (
	"github.com/go-chi/chi/v5"
	"github.com/igorwulff/dragonfly/controllers"
	"github.com/igorwulff/dragonfly/templates"
	"github.com/igorwulff/dragonfly/views"
)

func InitCmsRouter(r *chi.Mux) {
	r.Get("/", controllers.StaticHandler(views.Must(views.ParseFS(
		templates.FS,
		"cms/index.gohtml", "layout/*",
	))))
}
