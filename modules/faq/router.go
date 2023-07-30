package faq

import (
	"html/template"
	"net/http"

	"github.com/go-chi/chi/v5"
	"github.com/igorwulff/dragonfly/framework"
	"github.com/igorwulff/dragonfly/templates"
)

func InitRouter(r *chi.Mux) {
	var _, _ = GetPersonByName("test")

	tplFaq := framework.Must(framework.ParseFS(templates.FS, "faq/index.gohtml", "layout/*"))
	r.Get("/faq", Faq(tplFaq))
}

func Faq(tpl framework.Template) http.HandlerFunc {
	questions := []struct {
		Question template.HTML
		Answer   template.HTML
	}{
		{
			Question: "Is there a free version?",
			Answer:   "Yes! We offer a free trial for 30 days on any paid plans.",
		},
		{
			Question: "What are your support hours?",
			Answer:   "We have support staff answering emails 24/7, though response times may be a bit slower on weekends.",
		},
		{
			Question: "How do I contact support?",
			Answer:   `Email us - <a href="mailto:support@lenslocked.com">support@lenslocked.com</a>`,
		},
	}

	return func(w http.ResponseWriter, r *http.Request) {
		tpl.Execute(w, questions)
	}
}
