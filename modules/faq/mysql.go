package faq

import (
	sq "github.com/Masterminds/squirrel"
	db "github.com/igorwulff/dragonfly/framework"
)

type Person struct {
	id   int64
	name string
}

func GetPersonByName(name string) (Person, error) {
	var person Person
	err := sq.
		Select("id, name").
		From("test").
		Where(sq.Like{"name": name + "%"}).
		Limit(1).
		RunWith(db.GetDb()).
		QueryRow().
		Scan(&person.id, &person.name)
	return person, err
}

func getPersonsByName(name string) ([]Person, error) {
	var persons []Person
	rows, _ := sq.
		Select("id, name").
		From("test").
		Where(sq.Like{"name": name + "%"}).
		RunWith(db.GetDb()).
		Query()

	for rows.Next() {
		var row Person
		rows.Scan(&row.id, &row.name)
		persons = append(persons, row)
	}

	return persons, nil
}
