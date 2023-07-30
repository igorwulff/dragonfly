package contact

import (
	"net/http"

	"github.com/go-chi/chi/v5"
	"github.com/igorwulff/dragonfly/framework"
	"github.com/igorwulff/dragonfly/templates"
)

func InitRouter(r *chi.Mux) {
	r.Route("/contact", func(r chi.Router) {
		tplContact := framework.Must(framework.ParseFS(templates.FS, "contact/index.gohtml", "layout/*"))
		r.Get("/", framework.StaticHandler(tplContact))

		tplContactForm := framework.Must(framework.ParseFS(templates.FS, "contact/form.gohtml", "layout/*"))
		r.Get("/{id:[0-9]+}/edit", framework.StaticHandler(tplContactForm))

		r.Put("/{id:[0-9]+}", func(w http.ResponseWriter, r *http.Request) {
			w.Write([]byte("this is put method"))
		})
	})

}
