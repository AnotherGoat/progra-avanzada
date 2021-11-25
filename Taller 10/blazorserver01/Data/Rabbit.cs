namespace blazorserver01.Data
{
    public class Rabbit: Data.BioUnit
    {
        public Rabbit(int x, int y) : base(x, y) => this.color = "#fafafa";
    }
    // base for calling the parent's constructor
}