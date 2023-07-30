package framework

import (
	"database/sql"
	"fmt"
	"log"
	"sync"
	"time"

	sq "github.com/Masterminds/squirrel"
	"github.com/go-sql-driver/mysql"
)

var once sync.Once

var db *sql.DB

var dbCache *sq.StmtCache

func GetDb() sq.BaseRunner {
	// StmtCache caches Prepared Stmts for you

	if dbCache == nil {
		// Ensure this gets only called once even with goroutines
		once.Do(
			func() {
				fmt.Println("Creating single instance now.")

				// Capture connection properties.
				cfg := mysql.Config{
					User:                 "dragonfly",
					Passwd:               "nNYxP3vti6EMjp",
					Net:                  "tcp",
					Addr:                 "127.0.0.1:3306",
					DBName:               "dragonfly",
					AllowNativePasswords: true,
				}
				// Get a database handle.
				db, err := sql.Open("mysql", cfg.FormatDSN())
				db.SetMaxOpenConns(25)
				db.SetMaxIdleConns(25)
				db.SetConnMaxLifetime(5 * time.Minute)
				if err != nil {
					log.Fatal(err)
				}

				pingErr := db.Ping()
				if pingErr != nil {
					log.Fatal(pingErr)
				}
				fmt.Println("Connected!")

				// StmtCache caches Prepared Stmts for you
				dbCache = sq.NewStmtCache(db)
			})
	} else {
		fmt.Println("Single instance already created.")
	}

	return dbCache
}
