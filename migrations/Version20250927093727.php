<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250927093727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $firstCardTitle = '<h4 class="my-0 font-weight-normal">Card Title</h4>';
        $firstCardHtml = '<img style="width: 25em;cursor: pointer;" src="https://static.wikia.nocookie.net/floppapedia-revamped/images/e/e7/Lord_Foog_the_2st.jpg/revision/latest/thumbnail/width/360/height/360?cb=20220509155905" class="img-fluid" data-target="#exampleModal" data-toggle="modal" hx-get="/home/ref" hx-target="#modal-body" hx-swap="innerHTML">';
        $secondCardTitle = '<h4 class="my-0 font-weight-normal">About Me</h4>';
        $secondCardHtml = '<ul class="list-unstyled mt-3 mb-4">
                            <li> Software Engineering </li>

                        </ul>';

        $thirdCardTitle = '<h4 class="my-0 font-weight-normal">Links</h4>';
        $thirdCardHtml = '<ul class="list-unstyled mt-3 mb-4">
                            <li><a href="/gallery" target="_blank">Gallery</a></li>
                            <li><a href="https://x.com/" target="_blank">Twitter</a></li>

                        </ul>';
        //dd('INSERT INTO info_card (title, card_body, ordering, col_size, col_offset) VALUES ("'. $firstCardTitle .'", "'. $firstCardHtml .'", 1, 4, 0)');
        // this up() migration is auto-generated, please modify it to your needs
        $lastCardTitle = '<h4 class="my-0 font-weight-normal">Snoopa</h4>';
        $lastCardHtml = '<img style="width: 25em;" src="/assets/snoopa.gif" class="img-fluid">';
        $cards = [
            [
                'title' => $firstCardTitle,
                'body' => $firstCardHtml,
                'ordering' => 1,
                'col_size' => 4,
                'col_offset' => 0,
            ],
            [
                'title' => $secondCardTitle,
                'body' => $secondCardHtml,
                'ordering' => 2,
                'col_size' => 4,
                'col_offset' => 0,
            ],
            [
                'title' => $thirdCardTitle,
                'body' => $thirdCardHtml,
                'ordering' => 3,
                'col_size' => 4,
                'col_offset' => 0,
            ],
            [
                'title' => $lastCardTitle,
                'body' => $lastCardHtml,
                'ordering' => 4,
                'col_size' => 4,
                'col_offset' => 4,
            ]
        ];
        $this->addSql('CREATE TABLE info_card (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title CLOB NOT NULL, card_body CLOB NOT NULL, col_size INTEGER NOT NULL, ordering INTEGER NOT NULL, col_offset integer not null )');
        /*$this->addSql('INSERT INTO info_card (title, card_body, ordering, col_size, col_offset) VALUES ("'. $firstCardTitle .'", "'. $firstCardHtml .'", 1, 4, 0)');
        $this->addSql('INSERT INTO info_card (title, card_body, ordering, col_size, col_offset) VALUES ("'. $secondCardTitle .'", "'. $secondCardHtml .'", 2, 4, 0)');
        $this->addSql('INSERT INTO info_card (title, card_body, ordering, col_size, col_offset) VALUES ("'. $thirdCardTitle .'", "'. $thirdCardHtml .'", 3, 4, 0)');
        $this->addSql('INSERT INTO info_card (title, card_body, ordering, col_size, col_offset) VALUES ("'. $lastCardTitle .'", "'. $lastCardHtml .'", 4, 4, 4)');*/
        foreach ($cards as $card) {
            $this->addSql("INSERT INTO info_card (title, card_body, ordering, col_size, col_offset) VALUES (
        '".str_replace("'", "''", $card['title'])."',
        '".str_replace("'", "''", $card['body'])."',
        {$card['ordering']},
        {$card['col_size']},
        {$card['col_offset']}
    )");
        }


    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE info_card');
    }
}
