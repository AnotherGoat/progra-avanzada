namespace trabajofinal.Data
{
    public class Label
    {
        public string Text { get; set; }
        public int XPos { get; set; }
        public int YPos { get; set; }
        public int FontSize { get; set; }
        public Label(string text, int xPos, int yPos, int fontSize)
        {
            Text = text;
            XPos = xPos;
            YPos = yPos;
            FontSize = fontSize;
        }
    }
}