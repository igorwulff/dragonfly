package error

import (
	"net/http"

	"github.com/go-chi/chi/v5"
)

func InitRouter(r *chi.Mux) {
	r.NotFound(func(w http.ResponseWriter, r *http.Request) {
		http.Error(w, "Page not found", http.StatusNotFound)
	})
}
