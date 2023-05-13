<?php
final class dbHandler
{
    private $dataSource = "mysql:dbname=wordle;host=localhost;"; 
    private $username = "root";
    private $password = "";

    public function selectAll()
    {
        try{
            $pdo = new PDO($this->dataSource, $this->username, $this->password);

            $statement = $pdo->prepare("SELECT *, category.name FROM `word` INNER JOIN category ON category.categoryId = word.categoryId;");
    
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $exception){
            var_dump($exception);
            return false;
        }
    }

    public function selectCategories()
    {
        try{
            $pdo = new PDO($this->dataSource, $this->username, $this->password);

            $statement = $pdo->prepare("SELECT * FROM category");

            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        catch(PDOException $exception){
            var_dump($exception);
            return false;
        }
    }

    public function createWord($text, $categoryId)
    {
        try{
            $pdo = new PDO($this->dataSource, $this->username, $this->password);

            $statement = $pdo->prepare("INSERT INTO word(text, categoryId) VALUES(:text, :categoryId)");
            $statement->bindParam("text", $text, PDO::PARAM_STR);
            $statement->bindParam("categoryId", $categoryId, PDO::PARAM_INT);
            $statement->execute();

            return true;
        }
        catch(PDOException $exception){
            var_dump($exception);
            return false;
        }
    }

    public function selectOne($wordId){
        try{
            $pdo = new PDO($this->dataSource, $this->username, $this->password);

            $statement = $pdo->prepare("SELECT wordId, text, category.name FROM `word` 
            INNER JOIN category ON category.categoryId = word.categoryId WHERE wordId = :wordId");
            $statement->bindParam("wordId", $wordId, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC)[0];

        }
        catch(PDOException $exception){
            var_dump($exception);
            return false;
        }
    }

    public function updateWord($wordId, $text, $category){
        try{
        $pdo = new PDO($this->dataSource, $this->username, $this->password);

        $statement = $pdo->prepare("UPDATE word SET text = :text, categoryId = :category WHERE wordId = :wordId");
        $statement->bindParam("text", $text, PDO::PARAM_STR);
        $statement->bindParam("category", $category, PDO::PARAM_INT);
        $statement->bindParam("wordId", $wordId, PDO::PARAM_INT);
        $statement->execute();
        return true;
        }
        catch(PDOException $exception){
            var_dump($exception);
            return false;
        }
    }

    public function deleteWord($id){
        try{
        $pdo = new PDO($this->dataSource, $this->username, $this->password);

        $statement = $pdo->prepare("DELETE FROM word WHERE wordId = :id");
        $statement->bindParam("id", $id, PDO::PARAM_INT);
        $statement->execute();
        return true;

        }
        catch(PDOException $e){
            var_dump($e);
            return false;
        }

    }
}
?>