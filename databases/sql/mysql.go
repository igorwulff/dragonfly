package databases

import (
	"database/sql"
	"fmt"
	"log"
	"os"
	"sync"

	"github.com/go-sql-driver/mysql"
)

var once sync.Once

var dbInstance *sql.DB

func connect() *sql.DB {
	// Capture connection properties.
	cfg := mysql.Config{
		User:   os.Getenv("DBUSER"),
		Passwd: os.Getenv("DBPASS"),
		Net:    "tcp",
		Addr:   "127.0.0.1:3306",
		DBName: "recordings",
	}
	// Get a database handle.
	db, err := sql.Open("mysql", cfg.FormatDSN())
	if err != nil {
		log.Fatal(err)
	}

	pingErr := db.Ping()
	if pingErr != nil {
		log.Fatal(pingErr)
	}
	fmt.Println("Connected!")

	return db
}

//Port: 3306

func getInstance() *sql.DB {
	if dbInstance == nil {
		// Ensure this gets only called once even with goroutines
		once.Do(
			func() {
				fmt.Println("Creating single instance now.")
				dbInstance = connect()
			})
	} else {
		fmt.Println("Single instance already created.")
	}

	return dbInstance
}

type Name struct {
	id   int64
	name string
}

func NamesStartingWith(name string) ([]Name, error) {
	// An albums slice to hold data from returned rows.
	var names []Name

	rows, err := getInstance().Query("SELECT * FROM test WHERE name LIKE ?", fmt.Sprintf("%s%s", name, "%"))
	if err != nil {
		return nil, fmt.Errorf("albumsByArtist %q: %v", name, err)
	}
	defer rows.Close()
	// Loop through rows, using Scan to assign column data to struct fields.
	for rows.Next() {
		var name Name
		if err := rows.Scan(&name.id, &name.name); err != nil {
			return nil, fmt.Errorf("albumsByArtist %q: %v", name, err)
		}
		names = append(names, name)
	}
	if err := rows.Err(); err != nil {
		return nil, fmt.Errorf("albumsByArtist %q: %v", name, err)
	}
	return names, nil
}
