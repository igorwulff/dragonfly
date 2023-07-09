package routers

import (
	"net/http"

	"github.com/go-chi/chi/v5"
)

func Init404Router(r *chi.Mux) {
	r.NotFound(func(w http.ResponseWriter, r *http.Request) {
		http.Error(w, "Page not found", http.StatusNotFound)
	})
}
