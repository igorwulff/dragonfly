package main

import (
	"fmt"
	"net/http"

	"github.com/go-chi/chi/v5"
	"github.com/go-chi/chi/v5/middleware"
	"github.com/igorwulff/dragonfly/routers"
)

func handler(w http.ResponseWriter, r *http.Request) {
	return
}

func main() {
	r := chi.NewRouter()
	r.Use(middleware.Logger)

	routers.InitCmsRouter(r)
	routers.InitFaqRouter(r)
	routers.InitContactRouter(r)
	routers.Init404Router(r)

	fmt.Println("Starting the server on :3000...")
	http.ListenAndServe(":3000", r)
}
