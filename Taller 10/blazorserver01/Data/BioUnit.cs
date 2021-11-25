namespace blazorserver01.Data
{
    public class BioUnit
    {
        protected string color;
        public int posx;
        public int posy;
        public BioUnit(int x, int y) {
            this.posx = x;
            this.posy = y;
            this.color = "#444444";
        }
        public string myColor() => this.color;
    }
}