package cms

import (
	"github.com/go-chi/chi/v5"
	"github.com/igorwulff/dragonfly/framework"
	"github.com/igorwulff/dragonfly/templates"
)

func InitRouter(r *chi.Mux) {
	r.Get("/", framework.StaticHandler(framework.Must(framework.ParseFS(
		templates.FS,
		"cms/index.gohtml", "layout/*",
	))))
}
